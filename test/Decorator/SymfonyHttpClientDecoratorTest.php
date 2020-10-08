<?php

namespace Test\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\SymfonyHttpClientDecorator;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TimeoutExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

class SymfonyHttpClientDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new SymfonyHttpClientDecorator();
        $this->decorator
            ->setDiagnosisFactory($this->getDiagnosisFactoryMock())
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testClientExceptionInterface()
    {
        $analysedThrowable = $this->createMock(ClientExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testDecodingExceptionInterface()
    {
        $analysedThrowable = $this->createMock(DecodingExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testExceptionInterface()
    {
        $analysedThrowable = $this->createMock(ExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testHttpExceptionInterface()
    {
        $analysedThrowable = $this->createMock(HttpExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testRedirectionExceptionInterface()
    {
        $analysedThrowable = $this->createMock(RedirectionExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testServerExceptionInterface()
    {
        $analysedThrowable = $this->createMock(ServerExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testTimeoutExceptionInterface()
    {
        $analysedThrowable = $this->createMock(TimeoutExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosis = $this->expectDiagnosisCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosis);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testTransportExceptionInterface()
    {
        $analysedThrowable = $this->createMock(TransportExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosis = $this->expectDiagnosisCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosis);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testForwardsDummyThrowable()
    {
        $analysedThrowable = $this->createMock(Throwable::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
        $this->decorator->diagnose($analysedThrowable);
    }
}

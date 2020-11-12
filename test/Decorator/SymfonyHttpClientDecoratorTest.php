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
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class SymfonyHttpClientDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new SymfonyHttpClientDecorator();
        $this->decorator
            ->setDiagnosedFactory($this->getDiagnosedFactoryMock())
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function test422ClientExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(422);
        $analysedThrowable = $this->createMock(ClientExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test429ClientExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(429);
        $analysedThrowable = $this->createMock(ClientExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testDecodingExceptionInterface()
    {
        $analysedThrowable = $this->createMock(DecodingExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testExceptionInterface()
    {
        $analysedThrowable = $this->createMock(ExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testHttpExceptionInterface()
    {
        $analysedThrowable = $this->createMock(HttpExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testRedirectionExceptionInterface()
    {
        $analysedThrowable = $this->createMock(RedirectionExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test500ServerExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(500);
        $analysedThrowable = $this->createMock(ServerExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test503ServerExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(503);
        $analysedThrowable = $this->createMock(ServerExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testTimeoutExceptionInterface()
    {
        $analysedThrowable = $this->createMock(TimeoutExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testTransportExceptionInterface()
    {
        $analysedThrowable = $this->createMock(TransportExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testForwardsDummyThrowable()
    {
        $analysedThrowable = $this->createMock(Throwable::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }
}

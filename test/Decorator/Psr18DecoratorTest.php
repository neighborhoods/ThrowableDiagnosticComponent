<?php

namespace Test\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Psr18Decorator;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Client\RequestExceptionInterface;
use Throwable;

class Psr18DecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new Psr18Decorator();
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

    public function testNetworkExceptionInterface()
    {
        $analysedThrowable = $this->createMock(NetworkExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosis = $this->expectDiagnosisCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosis);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testRequestExceptionInterface()
    {
        $analysedThrowable = $this->createMock(RequestExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosisCreation();
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

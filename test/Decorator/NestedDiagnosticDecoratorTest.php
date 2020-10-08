<?php

namespace Test\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\NestedDiagnosticDecorator;
use Throwable;

class NestedDiagnosticDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new NestedDiagnosticDecorator();
        $this->decorator
            ->setDiagnosisFactory($this->getDiagnosisFactoryMock())
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testThrowsAnalysedDiagnosis()
    {
        $analysedThrowable = $this->createMock(DiagnosisInterface::class);
        $this->expectNoForwarding();
        $this->expectNoDiagnosisCreation();
        $this->expectExceptionObject($analysedThrowable);
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

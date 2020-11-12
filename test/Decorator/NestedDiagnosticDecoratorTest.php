<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;
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
            ->setDiagnosedFactory($this->getDiagnosedFactoryMock())
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testThrowsAnalysedDiagnosed()
    {
        $analysedThrowable = $this->createMock(DiagnosedInterface::class);
        $this->expectNoForwarding();
        $this->expectNoDiagnosedCreation();
        $this->expectExceptionObject($analysedThrowable);
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

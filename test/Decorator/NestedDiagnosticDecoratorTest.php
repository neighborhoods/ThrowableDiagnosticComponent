<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;
// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\NestedDiagnosticV1\NestedDiagnosticDecorator;
use Throwable;

class NestedDiagnosticDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new NestedDiagnosticDecorator();
        $this->decorator
            ->setThrowableDiagnosticV1DiagnosedFactory($this->getDiagnosedFactoryMock())
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticMock());
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

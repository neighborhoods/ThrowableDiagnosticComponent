<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;
// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\NestedDiagnosticV1\NestedDiagnosticDecorator;
use Throwable;
use PHPUnit\Framework\TestCase;

class NestedDiagnosticDecoratorTest extends TestCase
{
    use ThrowableDiagnosticMockerTrait;

    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new NestedDiagnosticDecorator();
        $this->decorator
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testThrowsAnalysedDiagnosed()
    {
        $analysedThrowable = $this->createMock(DiagnosedInterface::class);
        $this->expectNoForwarding();
        $this->expectExceptionObject($analysedThrowable);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testForwardsDummyThrowable()
    {
        $analysedThrowable = $this->createMock(Throwable::class);
        $this->expectForwarding($analysedThrowable);
        $this->decorator->diagnose($analysedThrowable);
    }
}

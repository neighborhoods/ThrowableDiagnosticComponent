<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\Decorator;

use DDTrace\Contracts\Tracer;
use DDTrace\Contracts\Span;
use Neighborhoods\DatadogComponent\GlobalTracer;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\ReportToDatadogDecorator;
use Throwable;

class ReportToDatadogDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    private $globalTracerRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->globalTracerRepositoryMock = $this->createMock(
            GlobalTracer\RepositoryInterface::class
        );

        $this->decorator = new ReportToDatadogDecorator();
        $this->decorator
            ->setGlobalTracerRepository($this->globalTracerRepositoryMock)
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testDiagnoseLogsToActiveSpanAndForwardsThrowable()
    {
        $analysedThrowable = $this->createMock(Throwable::class);

        $spanMock = $this->createMock(Span::class);
        $spanMock->expects(self::once())
            ->method('setError');
        $globalTracerMock = $this->createMock(Tracer::class);
        $globalTracerMock->expects(self::atLeastOnce())
            ->method('getActiveSpan')
            ->willReturn($spanMock);
        $this->globalTracerRepositoryMock->expects(self::once())
            ->method('get')
            ->willReturn($globalTracerMock);

        $this->expectForwarding($analysedThrowable);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testDiagnoseWithoutActiveSpanForwardsThrowable()
    {
        $analysedThrowable = $this->createMock(Throwable::class);

        $globalTracerMock = $this->createMock(Tracer::class);
        $globalTracerMock->expects(self::atLeastOnce())
            ->method('getActiveSpan')
            ->willReturn(null);
        $this->globalTracerRepositoryMock->expects(self::once())
            ->method('get')
            ->willReturn($globalTracerMock);

        $this->expectForwarding($analysedThrowable);
        $this->decorator->diagnose($analysedThrowable);
    }
}

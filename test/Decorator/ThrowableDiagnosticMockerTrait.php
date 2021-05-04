<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use Throwable;

trait ThrowableDiagnosticMockerTrait
{
    private $throwableDiagnosticMock;

    protected function getThrowableDiagnosticMock()
    {
        if (!isset($this->throwableDiagnosticMock)) {
            $this->throwableDiagnosticMock = $this->createMock(ThrowableDiagnosticInterface::class);
        }
        return $this->throwableDiagnosticMock;
    }

    protected function expectNoForwarding()
    {
        return $this->getThrowableDiagnosticMock()
            ->expects(self::never())
            ->method('diagnose');
    }

    protected function expectForwarding(Throwable $throwable): InvocationMocker
    {
        return $this->getThrowableDiagnosticMock()
            ->expects(self::once())
            ->method('diagnose')
            ->with($throwable)
            ->willReturnSelf();
    }
}

<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use PHPUnit\Framework\MockObject\Builder\InvocationMocker;
use Throwable;

trait ThrowableDiagnosticMockerTrait
{
    private $throwableDiagnosticMock;

    protected function getThrowableDiagnosticV1ThrowableDiagnosticMock()
    {
        if (!isset($this->throwableDiagnosticMock)) {
            $this->throwableDiagnosticMock = $this->createMock(ThrowableDiagnosticInterface::class);
        }
        return $this->throwableDiagnosticMock;
    }

    protected function expectNoForwarding()
    {
        return $this->getThrowableDiagnosticV1ThrowableDiagnosticMock()
            ->expects(self::never())
            ->method('diagnose');
    }

    protected function expectForwarding(Throwable $throwable): InvocationMocker
    {
        return $this->getThrowableDiagnosticV1ThrowableDiagnosticMock()
            ->expects(self::once())
            ->method('diagnose')
            ->with($throwable)
            ->willReturnSelf();
    }
}

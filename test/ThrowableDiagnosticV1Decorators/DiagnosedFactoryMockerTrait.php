<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;
use Throwable;

trait DiagnosedFactoryMockerTrait
{
    private $diagnosedFactoryMock;

    protected function getThrowableDiagnosticV1DiagnosedFactoryMock()
    {
        if (!isset($this->diagnosedFactoryMock)) {
            $this->diagnosedFactoryMock = $this->createMock(Diagnosed\FactoryInterface::class);
        }
        return $this->diagnosedFactoryMock;
    }

    protected function expectDiagnosedCreation(
        Throwable $previous,
        bool $transient,
        string $code = null,
        array $messages = null
    ): DiagnosedInterface {
        $diagnosedMock = $this->createMock(DiagnosedInterface::class);
        $diagnosedMock->expects(self::once())
            ->method('setPrevious')
            ->with($previous)
            ->willReturnSelf();

        $diagnosedMock->expects(self::once())
            ->method('setTransient')
            ->with($transient)
            ->willReturnSelf();

        if (isset($code)) {
            $diagnosedMock->expects(self::once())
                ->method('setCode')
                ->with($code)
                ->willReturnSelf();
        } else {
            $diagnosedMock->expects(self::never())
                ->method('setCode');
        }

        if (isset($messages)) {
            $consecutiveArgs = array_map(function ($message) {
                // Only one argument, which is the message.
                return [$message];
            }, $messages);
            $diagnosedMock->expects(self::exactly(count($messages)))
                ->method('addMessage')
                ->withConsecutive($consecutiveArgs)
                ->willReturnSelf();
        } else {
            $diagnosedMock->expects(self::never())
                ->method('addMessage');
        }

        $this->getThrowableDiagnosticV1DiagnosedFactoryMock()
            ->expects(self::once())
            ->method('create')
            ->willReturn($diagnosedMock);

        return $diagnosedMock;
    }

    protected function expectNoDiagnosedCreation()
    {
        $this->getThrowableDiagnosticV1DiagnosedFactoryMock()
            ->expects(self::never())
            ->method('create');
    }
}

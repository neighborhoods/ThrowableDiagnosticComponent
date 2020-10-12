<?php

namespace Test\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;
use Throwable;


trait DiagnosedFactoryMockerTrait
{
    private $diagnosedFactoryMock;

    protected function getDiagnosedFactoryMock()
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

        $this->getDiagnosedFactoryMock()
            ->expects(self::once())
            ->method('create')
            ->willReturn($diagnosedMock);

        return $diagnosedMock;
    }

    protected function expectNoDiagnosedCreation()
    {
        $this->getDiagnosedFactoryMock()
            ->expects(self::never())
            ->method('create');
    }
}

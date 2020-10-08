<?php

namespace Test\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;
use Throwable;


trait DiagnosisFactoryMockerTrait
{
    private $diagnosisFactoryMock;

    protected function getDiagnosisFactoryMock()
    {
        if (!isset($this->diagnosisFactoryMock)) {
            $this->diagnosisFactoryMock = $this->createMock(Diagnosis\FactoryInterface::class);
        }
        return $this->diagnosisFactoryMock;
    }

    protected function expectDiagnosisCreation(
        Throwable $previous,
        bool $transient,
        string $code = null,
        array $messages = null
    ): DiagnosisInterface {
        $diagnosisMock = $this->createMock(DiagnosisInterface::class);
        $diagnosisMock->expects(self::once())
            ->method('setPrevious')
            ->with($previous)
            ->willReturnSelf();

        $diagnosisMock->expects(self::once())
            ->method('setTransient')
            ->with($transient)
            ->willReturnSelf();

        if (isset($code)) {
            $diagnosisMock->expects(self::once())
                ->method('setCode')
                ->with($code)
                ->willReturnSelf();
        } else {
            $diagnosisMock->expects(self::never())
                ->method('setCode');
        }

        if (isset($messages)) {
            $consecutiveArgs = array_map(function ($message) {
                // Only one argument, which is the message.
                return [$message];
            }, $messages);
            $diagnosisMock->expects(self::exactly(count($messages)))
                ->method('addMessage')
                ->withConsecutive($consecutiveArgs)
                ->willReturnSelf();
        } else {
            $diagnosisMock->expects(self::never())
                ->method('addMessage');
        }

        $this->getDiagnosisFactoryMock()
            ->expects(self::once())
            ->method('create')
            ->willReturn($diagnosisMock);

        return $diagnosisMock;
    }

    protected function expectNoDiagnosisCreation()
    {
        $this->getDiagnosisFactoryMock()
            ->expects(self::never())
            ->method('create');
    }
}

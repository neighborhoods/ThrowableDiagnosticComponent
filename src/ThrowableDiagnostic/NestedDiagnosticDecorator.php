<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Throwable;

class NestedDiagnosticDecorator implements NestedDiagnosticDecoratorInterface
{
    use AwareTrait;
    use Diagnosis\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof DiagnosisInterface) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw $throwable;
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

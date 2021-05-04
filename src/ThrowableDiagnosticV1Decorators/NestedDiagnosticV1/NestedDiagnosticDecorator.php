<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\NestedDiagnosticV1;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Throwable;

final class NestedDiagnosticDecorator implements NestedDiagnosticDecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof DiagnosedInterface) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw $throwable;
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

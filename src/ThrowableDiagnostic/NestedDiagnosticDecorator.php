<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Throwable;

final class NestedDiagnosticDecorator implements NestedDiagnosticDecoratorInterface
{
    use AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof DiagnosedInterface) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw $throwable;
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

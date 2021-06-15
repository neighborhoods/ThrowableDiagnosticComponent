<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators\PhpUnitV1;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\DecoratorInterface;
use PHPUnit\Framework\ExpectationFailedException;
use Throwable;

final class PhpUnitDecorator implements DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // Preserve exceptions due to failed asserts.
        if ($throwable instanceof ExpectationFailedException) {
            throw $throwable;
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

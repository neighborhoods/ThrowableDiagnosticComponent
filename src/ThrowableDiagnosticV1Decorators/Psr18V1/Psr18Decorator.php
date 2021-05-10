<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\Psr18V1;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Throwable;

final class Psr18Decorator implements Psr18DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        $transient = $throwable instanceof NetworkExceptionInterface;
        if ($transient) {
            throw $this->getThrowableDiagnosticV1DiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

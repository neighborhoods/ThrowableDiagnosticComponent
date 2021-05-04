<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\TransientV1;

use Neighborhoods\ExceptionComponent\TransientExceptionInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Throwable;

final class TransientDecorator implements TransientDecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    /**
     * @todo - consider removing this class later since the Exception Component should be replaced by
     * this system.
     */
    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof TransientExceptionInterface) {
            throw $this->getThrowableDiagnosticV1DiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

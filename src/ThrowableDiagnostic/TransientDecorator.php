<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ExceptionComponent\TransientExceptionInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Throwable;

final class TransientDecorator implements TransientDecoratorInterface
{
    use AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    /**
     * @todo - consider removing this class later since the Exception Component should be replaced by
     * this system.
     */
    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof TransientExceptionInterface) {
            throw $this->getDiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

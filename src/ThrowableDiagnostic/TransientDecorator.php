<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ExceptionComponent\TransientExceptionInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Throwable;

class TransientDecorator implements TransientDecoratorInterface
{
    use AwareTrait;
    use Diagnosis\Factory\AwareTrait;

    /**
     * @todo - consider removing this class later since the Exception Component should be replaced by
     * this system.
     */
    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof TransientExceptionInterface) {
            throw $this->getDiagnosisFactory()
                ->create()
                ->setThrowable($throwable)
                ->setTransient(true);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

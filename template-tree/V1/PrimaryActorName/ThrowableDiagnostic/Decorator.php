<?php
declare(strict_types=1);

namespace Neighborhoods\BuphaloTemplateTree\PrimaryActorName\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Throwable;

class Decorator implements DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosis\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        /** @neighborhoods-buphalo:annotation-processor Neighborhoods\BuphaloTemplateTree\ThrowableDiagnostic\Decorator.diagnose
        // TODO: Implement diagnose() method.
        throw new \LogicException('Unimplemented custom diagnostic.');
         */
        if (false) {
            throw $this->getDiagnosisFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

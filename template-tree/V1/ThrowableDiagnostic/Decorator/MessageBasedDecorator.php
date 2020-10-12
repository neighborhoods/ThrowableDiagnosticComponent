<?php
declare(strict_types=1);

namespace Neighborhoods\BuphaloTemplateTree;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Throwable;

final class PrimaryActorName implements PrimaryActorNameInterface
{
    const TRANSIENT_MESSAGE_PART = 'TODO';

    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        /** @neighborhoods-buphalo:annotation-processor Neighborhoods\BuphaloTemplateTree\ThrowableDiagnostic\Decorator\MessageBasedDecorator.diagnose
        // TODO: Update TRANSIENT_MESSAGE_PART above and remove line below.
        throw new \LogicException('Unchanged TRANSIENT_MESSAGE_PART in ' . self::class . '.');
         */
        // Check if exception message contains transient message part
        if (strpos($throwable->getMessage(), self::TRANSIENT_MESSAGE_PART) !== false) {
            /** @noinspection PhpUnhandledExceptionInspection */
            throw $this->getDiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

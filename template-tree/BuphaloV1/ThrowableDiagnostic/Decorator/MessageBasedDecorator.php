<?php

declare(strict_types=1);

namespace Neighborhoods\BuphaloTemplateTree;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Throwable;

final class PrimaryActorName implements PrimaryActorNameInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    const TRANSIENT_MESSAGE_PART = 'TODO';

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

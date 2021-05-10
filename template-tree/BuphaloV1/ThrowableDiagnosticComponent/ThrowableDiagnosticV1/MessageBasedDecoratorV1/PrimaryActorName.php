<?php

declare(strict_types=1);

namespace Neighborhoods\BuphaloTemplateTree;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Throwable;

final class PrimaryActorName implements PrimaryActorNameInterface
{
    use ThrowableDiagnostic\AwareTrait;

    const MESSAGE_PART = 'TODO';

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        /** @neighborhoods-buphalo:annotation-processor Neighborhoods\BuphaloTemplateTree\ThrowableDiagnostic\Decorator\MessageBasedDecorator.diagnose
        // TODO: Update MESSAGE_PART above and remove line below.
        throw new \LogicException('Unchanged MESSAGE_PART in ' . self::class . '.');
         */
        // Check if exception message contains transient message part
        if (strpos($throwable->getMessage(), self::MESSAGE_PART) !== false) {
            return $this;
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

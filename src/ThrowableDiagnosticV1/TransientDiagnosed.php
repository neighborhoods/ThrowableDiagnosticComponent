<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1;

use Neighborhoods\ExceptionComponent\Exception;
use LogicException;

final class TransientDiagnosed extends Exception implements DiagnosedInterface
{
    public function setTransient(bool $transient): DiagnosedInterface
    {
        throw new LogicException('Cannot set transiency for transient diagnosed.');
    }

    public function isTransient(): bool
    {
        return true;
    }
}

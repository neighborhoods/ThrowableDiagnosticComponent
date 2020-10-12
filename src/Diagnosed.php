<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use Neighborhoods\ExceptionComponent\Exception;
use LogicException;

final class Diagnosed extends Exception implements DiagnosedInterface
{
    private /*bool*/ $transient;

    public function setTransient(bool $transient): DiagnosedInterface
    {
        if (isset($this->transient)) {
            throw new LogicException('Transient is already set.');
        }
        $this->transient = $transient;
        return $this;
    }

    public function isTransient(): bool
    {
        if (!isset($this->transient)) {
            throw new LogicException('Transient has not been set.');
        }
        return $this->transient;
    }
}

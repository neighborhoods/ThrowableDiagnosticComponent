<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use Exception;
use LogicException;
use Throwable;

class Diagnosis extends Exception implements DiagnosisInterface
{
    private /*bool*/ $transient;
    private /*Throwable*/ $throwable;

    public function setThrowable(Throwable $throwable): DiagnosisInterface
    {
        if (isset($this->throwable)) {
            throw new LogicException('Throwable is already set.');
        }
        $this->throwable = $throwable;
        return $this;
    }

    public function getThrowable(): Throwable
    {
        if (!isset($this->throwable)) {
            throw new LogicException('Throwable has not been set.');
        }
        return $this->throwable;
    }

    public function setTransient(bool $transient): DiagnosisInterface
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

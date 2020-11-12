<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;

trait AwareTrait
{
    protected $Diagnosed;

    public function setDiagnosed(DiagnosedInterface $Diagnosed): self
    {
        if ($this->hasDiagnosed()) {
            throw new LogicException('Diagnosed is already set.');
        }
        $this->Diagnosed = $Diagnosed;

        return $this;
    }

    protected function getDiagnosed(): DiagnosedInterface
    {
        if (!$this->hasDiagnosed()) {
            throw new LogicException('Diagnosed is not set.');
        }

        return $this->Diagnosed;
    }

    protected function hasDiagnosed(): bool
    {
        return isset($this->Diagnosed);
    }

    protected function unsetDiagnosed(): self
    {
        if (!$this->hasDiagnosed()) {
            throw new LogicException('Diagnosed is not set.');
        }
        unset($this->Diagnosed);

        return $this;
    }
}

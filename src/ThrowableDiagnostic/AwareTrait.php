<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;

trait AwareTrait
{
    protected $ThrowableDiagnostic;

    public function setThrowableDiagnostic(ThrowableDiagnosticInterface $ThrowableDiagnostic): self
    {
        if ($this->hasThrowableDiagnostic()) {
            throw new LogicException('ThrowableDiagnostic is already set.');
        }
        $this->ThrowableDiagnostic = $ThrowableDiagnostic;

        return $this;
    }

    protected function getThrowableDiagnostic(): ThrowableDiagnosticInterface
    {
        if (!$this->hasThrowableDiagnostic()) {
            throw new LogicException('ThrowableDiagnostic is not set.');
        }

        return $this->ThrowableDiagnostic;
    }

    protected function hasThrowableDiagnostic(): bool
    {
        return isset($this->ThrowableDiagnostic);
    }

    protected function unsetThrowableDiagnostic(): self
    {
        if (!$this->hasThrowableDiagnostic()) {
            throw new LogicException('ThrowableDiagnostic is not set.');
        }
        unset($this->ThrowableDiagnostic);

        return $this;
    }
}

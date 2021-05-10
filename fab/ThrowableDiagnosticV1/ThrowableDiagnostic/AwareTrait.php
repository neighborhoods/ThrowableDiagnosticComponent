<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1ThrowableDiagnostic;

    public function setThrowableDiagnosticV1ThrowableDiagnostic(ThrowableDiagnosticInterface $ThrowableDiagnostic): self
    {
        if ($this->hasThrowableDiagnosticV1ThrowableDiagnostic()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnostic is already set.');
        }
        $this->ThrowableDiagnosticV1ThrowableDiagnostic = $ThrowableDiagnostic;

        return $this;
    }

    protected function getThrowableDiagnosticV1ThrowableDiagnostic(): ThrowableDiagnosticInterface
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnostic()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnostic is not set.');
        }

        return $this->ThrowableDiagnosticV1ThrowableDiagnostic;
    }

    protected function hasThrowableDiagnosticV1ThrowableDiagnostic(): bool
    {
        return isset($this->ThrowableDiagnosticV1ThrowableDiagnostic);
    }

    protected function unsetThrowableDiagnosticV1ThrowableDiagnostic(): self
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnostic()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnostic is not set.');
        }
        unset($this->ThrowableDiagnosticV1ThrowableDiagnostic);

        return $this;
    }
}

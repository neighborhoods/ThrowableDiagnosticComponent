<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1Diagnosed;

    public function setThrowableDiagnosticV1Diagnosed(DiagnosedInterface $Diagnosed): self
    {
        if ($this->hasThrowableDiagnosticV1Diagnosed()) {
            throw new LogicException('ThrowableDiagnosticV1Diagnosed is already set.');
        }
        $this->ThrowableDiagnosticV1Diagnosed = $Diagnosed;

        return $this;
    }

    protected function getThrowableDiagnosticV1Diagnosed(): DiagnosedInterface
    {
        if (!$this->hasThrowableDiagnosticV1Diagnosed()) {
            throw new LogicException('ThrowableDiagnosticV1Diagnosed is not set.');
        }

        return $this->ThrowableDiagnosticV1Diagnosed;
    }

    protected function hasThrowableDiagnosticV1Diagnosed(): bool
    {
        return isset($this->ThrowableDiagnosticV1Diagnosed);
    }

    protected function unsetThrowableDiagnosticV1Diagnosed(): self
    {
        if (!$this->hasThrowableDiagnosticV1Diagnosed()) {
            throw new LogicException('ThrowableDiagnosticV1Diagnosed is not set.');
        }
        unset($this->ThrowableDiagnosticV1Diagnosed);

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosed\Factory;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed\FactoryInterface;

trait AwareTrait
{
    protected $DiagnosedFactory;

    public function setDiagnosedFactory(FactoryInterface $DiagnosedFactory): self
    {
        if ($this->hasDiagnosedFactory()) {
            throw new LogicException('DiagnosedFactory is already set.');
        }
        $this->DiagnosedFactory = $DiagnosedFactory;

        return $this;
    }

    protected function getDiagnosedFactory(): FactoryInterface
    {
        if (!$this->hasDiagnosedFactory()) {
            throw new LogicException('DiagnosedFactory is not set.');
        }

        return $this->DiagnosedFactory;
    }

    protected function hasDiagnosedFactory(): bool
    {
        return isset($this->DiagnosedFactory);
    }

    protected function unsetDiagnosedFactory(): self
    {
        if (!$this->hasDiagnosedFactory()) {
            throw new LogicException('DiagnosedFactory is not set.');
        }
        unset($this->DiagnosedFactory);

        return $this;
    }
}

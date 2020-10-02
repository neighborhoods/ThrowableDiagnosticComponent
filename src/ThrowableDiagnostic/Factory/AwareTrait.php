<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Factory;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\FactoryInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticFactory;

    public function setThrowableDiagnosticFactory(FactoryInterface $ThrowableDiagnosticFactory): self
    {
        if ($this->hasThrowableDiagnosticFactory()) {
            throw new LogicException('ThrowableDiagnosticFactory is already set.');
        }
        $this->ThrowableDiagnosticFactory = $ThrowableDiagnosticFactory;

        return $this;
    }

    protected function getThrowableDiagnosticFactory(): FactoryInterface
    {
        if (!$this->hasThrowableDiagnosticFactory()) {
            throw new LogicException('ThrowableDiagnosticFactory is not set.');
        }

        return $this->ThrowableDiagnosticFactory;
    }

    protected function hasThrowableDiagnosticFactory(): bool
    {
        return isset($this->ThrowableDiagnosticFactory);
    }

    protected function unsetThrowableDiagnosticFactory(): self
    {
        if (!$this->hasThrowableDiagnosticFactory()) {
            throw new LogicException('ThrowableDiagnosticFactory is not set.');
        }
        unset($this->ThrowableDiagnosticFactory);

        return $this;
    }
}

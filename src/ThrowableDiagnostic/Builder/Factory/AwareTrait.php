<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder\Factory;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder\FactoryInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticBuilderFactory;

    public function setThrowableDiagnosticBuilderFactory(FactoryInterface $ThrowableDiagnosticBuilderFactory): self
    {
        if ($this->hasThrowableDiagnosticBuilderFactory()) {
            throw new LogicException('ThrowableDiagnosticBuilderFactory is already set.');
        }
        $this->ThrowableDiagnosticBuilderFactory = $ThrowableDiagnosticBuilderFactory;

        return $this;
    }

    protected function getThrowableDiagnosticBuilderFactory(): FactoryInterface
    {
        if (!$this->hasThrowableDiagnosticBuilderFactory()) {
            throw new LogicException('ThrowableDiagnosticBuilderFactory is not set.');
        }

        return $this->ThrowableDiagnosticBuilderFactory;
    }

    protected function hasThrowableDiagnosticBuilderFactory(): bool
    {
        return isset($this->ThrowableDiagnosticBuilderFactory);
    }

    protected function unsetThrowableDiagnosticBuilderFactory(): self
    {
        if (!$this->hasThrowableDiagnosticBuilderFactory()) {
            throw new LogicException('ThrowableDiagnosticBuilderFactory is not set.');
        }
        unset($this->ThrowableDiagnosticBuilderFactory);

        return $this;
    }
}

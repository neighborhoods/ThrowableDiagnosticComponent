<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\BuilderInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticBuilder;

    public function setThrowableDiagnosticBuilder(BuilderInterface $ThrowableDiagnosticBuilder): self
    {
        if ($this->hasThrowableDiagnosticBuilder()) {
            throw new LogicException('ThrowableDiagnosticBuilder is already set.');
        }
        $this->ThrowableDiagnosticBuilder = $ThrowableDiagnosticBuilder;

        return $this;
    }

    protected function getThrowableDiagnosticBuilder(): BuilderInterface
    {
        if (!$this->hasThrowableDiagnosticBuilder()) {
            throw new LogicException('ThrowableDiagnosticBuilder is not set.');
        }

        return $this->ThrowableDiagnosticBuilder;
    }

    protected function hasThrowableDiagnosticBuilder(): bool
    {
        return isset($this->ThrowableDiagnosticBuilder);
    }

    protected function unsetThrowableDiagnosticBuilder(): self
    {
        if (!$this->hasThrowableDiagnosticBuilder()) {
            throw new LogicException('ThrowableDiagnosticBuilder is not set.');
        }
        unset($this->ThrowableDiagnosticBuilder);

        return $this;
    }
}

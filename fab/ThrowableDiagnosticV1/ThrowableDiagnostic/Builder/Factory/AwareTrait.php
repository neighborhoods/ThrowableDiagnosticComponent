<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Builder\Factory;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Builder\FactoryInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory;

    public function setThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory(FactoryInterface $ThrowableDiagnosticBuilderFactory): self
    {
        if ($this->hasThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory is already set.');
        }
        $this->ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory = $ThrowableDiagnosticBuilderFactory;

        return $this;
    }

    protected function getThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory(): FactoryInterface
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory is not set.');
        }

        return $this->ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory;
    }

    protected function hasThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory(): bool
    {
        return isset($this->ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory);
    }

    protected function unsetThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory(): self
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory is not set.');
        }
        unset($this->ThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory);

        return $this;
    }
}

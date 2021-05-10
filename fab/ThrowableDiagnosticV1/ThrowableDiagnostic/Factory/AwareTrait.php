<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Factory;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\FactoryInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1ThrowableDiagnosticFactory;

    public function setThrowableDiagnosticV1ThrowableDiagnosticFactory(FactoryInterface $ThrowableDiagnosticFactory): self
    {
        if ($this->hasThrowableDiagnosticV1ThrowableDiagnosticFactory()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticFactory is already set.');
        }
        $this->ThrowableDiagnosticV1ThrowableDiagnosticFactory = $ThrowableDiagnosticFactory;

        return $this;
    }

    protected function getThrowableDiagnosticV1ThrowableDiagnosticFactory(): FactoryInterface
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticFactory()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticFactory is not set.');
        }

        return $this->ThrowableDiagnosticV1ThrowableDiagnosticFactory;
    }

    protected function hasThrowableDiagnosticV1ThrowableDiagnosticFactory(): bool
    {
        return isset($this->ThrowableDiagnosticV1ThrowableDiagnosticFactory);
    }

    protected function unsetThrowableDiagnosticV1ThrowableDiagnosticFactory(): self
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticFactory()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticFactory is not set.');
        }
        unset($this->ThrowableDiagnosticV1ThrowableDiagnosticFactory);

        return $this;
    }
}

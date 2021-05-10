<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed\Factory;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed\FactoryInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DiagnosedFactory;

    public function setThrowableDiagnosticV1DiagnosedFactory(FactoryInterface $DiagnosedFactory): self
    {
        if ($this->hasThrowableDiagnosticV1DiagnosedFactory()) {
            throw new LogicException('ThrowableDiagnosticV1DiagnosedFactory is already set.');
        }
        $this->ThrowableDiagnosticV1DiagnosedFactory = $DiagnosedFactory;

        return $this;
    }

    protected function getThrowableDiagnosticV1DiagnosedFactory(): FactoryInterface
    {
        if (!$this->hasThrowableDiagnosticV1DiagnosedFactory()) {
            throw new LogicException('ThrowableDiagnosticV1DiagnosedFactory is not set.');
        }

        return $this->ThrowableDiagnosticV1DiagnosedFactory;
    }

    protected function hasThrowableDiagnosticV1DiagnosedFactory(): bool
    {
        return isset($this->ThrowableDiagnosticV1DiagnosedFactory);
    }

    protected function unsetThrowableDiagnosticV1DiagnosedFactory(): self
    {
        if (!$this->hasThrowableDiagnosticV1DiagnosedFactory()) {
            throw new LogicException('ThrowableDiagnosticV1DiagnosedFactory is not set.');
        }
        unset($this->ThrowableDiagnosticV1DiagnosedFactory);

        return $this;
    }
}

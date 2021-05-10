<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Builder;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\BuilderInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1ThrowableDiagnosticBuilder;

    public function setThrowableDiagnosticV1ThrowableDiagnosticBuilder(BuilderInterface $ThrowableDiagnosticBuilder): self
    {
        if ($this->hasThrowableDiagnosticV1ThrowableDiagnosticBuilder()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticBuilder is already set.');
        }
        $this->ThrowableDiagnosticV1ThrowableDiagnosticBuilder = $ThrowableDiagnosticBuilder;

        return $this;
    }

    protected function getThrowableDiagnosticV1ThrowableDiagnosticBuilder(): BuilderInterface
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticBuilder()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticBuilder is not set.');
        }

        return $this->ThrowableDiagnosticV1ThrowableDiagnosticBuilder;
    }

    protected function hasThrowableDiagnosticV1ThrowableDiagnosticBuilder(): bool
    {
        return isset($this->ThrowableDiagnosticV1ThrowableDiagnosticBuilder);
    }

    protected function unsetThrowableDiagnosticV1ThrowableDiagnosticBuilder(): self
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticBuilder()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticBuilder is not set.');
        }
        unset($this->ThrowableDiagnosticV1ThrowableDiagnosticBuilder);

        return $this;
    }
}

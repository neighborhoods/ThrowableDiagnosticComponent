<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Psr18Decorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Psr18DecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticPsr18Decorator;

    public function setThrowableDiagnosticPsr18Decorator(Psr18DecoratorInterface $Psr18Decorator): self
    {
        if ($this->hasThrowableDiagnosticPsr18Decorator()) {
            throw new LogicException('ThrowableDiagnosticPsr18Decorator is already set.');
        }
        $this->ThrowableDiagnosticPsr18Decorator = $Psr18Decorator;

        return $this;
    }

    protected function getThrowableDiagnosticPsr18Decorator(): Psr18DecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticPsr18Decorator()) {
            throw new LogicException('ThrowableDiagnosticPsr18Decorator is not set.');
        }

        return $this->ThrowableDiagnosticPsr18Decorator;
    }

    protected function hasThrowableDiagnosticPsr18Decorator(): bool
    {
        return isset($this->ThrowableDiagnosticPsr18Decorator);
    }

    protected function unsetThrowableDiagnosticPsr18Decorator(): self
    {
        if (!$this->hasThrowableDiagnosticPsr18Decorator()) {
            throw new LogicException('ThrowableDiagnosticPsr18Decorator is not set.');
        }
        unset($this->ThrowableDiagnosticPsr18Decorator);

        return $this;
    }
}

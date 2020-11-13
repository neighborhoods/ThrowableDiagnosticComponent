<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticDecorator;

    public function setThrowableDiagnosticDecorator(DecoratorInterface $Decorator): self
    {
        if ($this->hasThrowableDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticDecorator is already set.');
        }
        $this->ThrowableDiagnosticDecorator = $Decorator;

        return $this;
    }

    protected function getThrowableDiagnosticDecorator(): DecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticDecorator is not set.');
        }

        return $this->ThrowableDiagnosticDecorator;
    }

    protected function hasThrowableDiagnosticDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticDecorator);
    }

    protected function unsetThrowableDiagnosticDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticDecorator);

        return $this;
    }
}

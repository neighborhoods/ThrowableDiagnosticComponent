<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\NestedDiagnosticDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\NestedDiagnosticDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticNestedDiagnosticDecorator;

    public function setThrowableDiagnosticNestedDiagnosticDecorator(NestedDiagnosticDecoratorInterface $NestedDiagnosticDecorator): self
    {
        if ($this->hasThrowableDiagnosticNestedDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticNestedDiagnosticDecorator is already set.');
        }
        $this->ThrowableDiagnosticNestedDiagnosticDecorator = $NestedDiagnosticDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticNestedDiagnosticDecorator(): NestedDiagnosticDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticNestedDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticNestedDiagnosticDecorator is not set.');
        }

        return $this->ThrowableDiagnosticNestedDiagnosticDecorator;
    }

    protected function hasThrowableDiagnosticNestedDiagnosticDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticNestedDiagnosticDecorator);
    }

    protected function unsetThrowableDiagnosticNestedDiagnosticDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticNestedDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticNestedDiagnosticDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticNestedDiagnosticDecorator);

        return $this;
    }
}

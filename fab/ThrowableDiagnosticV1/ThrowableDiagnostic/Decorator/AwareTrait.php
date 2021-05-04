<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Decorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\DecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1ThrowableDiagnosticDecorator;

    public function setThrowableDiagnosticV1ThrowableDiagnosticDecorator(DecoratorInterface $Decorator): self
    {
        if ($this->hasThrowableDiagnosticV1ThrowableDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1ThrowableDiagnosticDecorator = $Decorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1ThrowableDiagnosticDecorator(): DecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1ThrowableDiagnosticDecorator;
    }

    protected function hasThrowableDiagnosticV1ThrowableDiagnosticDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1ThrowableDiagnosticDecorator);
    }

    protected function unsetThrowableDiagnosticV1ThrowableDiagnosticDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1ThrowableDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1ThrowableDiagnosticDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1ThrowableDiagnosticDecorator);

        return $this;
    }
}

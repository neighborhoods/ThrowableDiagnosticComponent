<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\MessageBasedDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\MessageBasedDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticMessageBasedDecorator;

    public function setThrowableDiagnosticMessageBasedDecorator(MessageBasedDecoratorInterface $MessageBasedDecorator): self
    {
        if ($this->hasThrowableDiagnosticMessageBasedDecorator()) {
            throw new LogicException('ThrowableDiagnosticMessageBasedDecorator is already set.');
        }
        $this->ThrowableDiagnosticMessageBasedDecorator = $MessageBasedDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticMessageBasedDecorator(): MessageBasedDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticMessageBasedDecorator()) {
            throw new LogicException('ThrowableDiagnosticMessageBasedDecorator is not set.');
        }

        return $this->ThrowableDiagnosticMessageBasedDecorator;
    }

    protected function hasThrowableDiagnosticMessageBasedDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticMessageBasedDecorator);
    }

    protected function unsetThrowableDiagnosticMessageBasedDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticMessageBasedDecorator()) {
            throw new LogicException('ThrowableDiagnosticMessageBasedDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticMessageBasedDecorator);

        return $this;
    }
}

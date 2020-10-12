<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\SnsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\SnsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticAwsSnsDecorator;

    public function setThrowableDiagnosticAwsSnsDecorator(SnsDecoratorInterface $SnsDecorator): self
    {
        if ($this->hasThrowableDiagnosticAwsSnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsSnsDecorator is already set.');
        }
        $this->ThrowableDiagnosticAwsSnsDecorator = $SnsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticAwsSnsDecorator(): SnsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticAwsSnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsSnsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticAwsSnsDecorator;
    }

    protected function hasThrowableDiagnosticAwsSnsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticAwsSnsDecorator);
    }

    protected function unsetThrowableDiagnosticAwsSnsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticAwsSnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsSnsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticAwsSnsDecorator);

        return $this;
    }
}

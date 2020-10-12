<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\SqsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\SqsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticAwsSqsDecorator;

    public function setThrowableDiagnosticAwsSqsDecorator(SqsDecoratorInterface $SqsDecorator): self
    {
        if ($this->hasThrowableDiagnosticAwsSqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsSqsDecorator is already set.');
        }
        $this->ThrowableDiagnosticAwsSqsDecorator = $SqsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticAwsSqsDecorator(): SqsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticAwsSqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsSqsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticAwsSqsDecorator;
    }

    protected function hasThrowableDiagnosticAwsSqsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticAwsSqsDecorator);
    }

    protected function unsetThrowableDiagnosticAwsSqsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticAwsSqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsSqsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticAwsSqsDecorator);

        return $this;
    }
}

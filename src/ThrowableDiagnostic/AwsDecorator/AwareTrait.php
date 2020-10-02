<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\AwsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\AwsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticAwsDecorator;

    public function setThrowableDiagnosticAwsDecorator(AwsDecoratorInterface $AwsDecorator): self
    {
        if ($this->hasThrowableDiagnosticAwsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsDecorator is already set.');
        }
        $this->ThrowableDiagnosticAwsDecorator = $AwsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticAwsDecorator(): AwsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticAwsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticAwsDecorator;
    }

    protected function hasThrowableDiagnosticAwsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticAwsDecorator);
    }

    protected function unsetThrowableDiagnosticAwsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticAwsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticAwsDecorator);

        return $this;
    }
}

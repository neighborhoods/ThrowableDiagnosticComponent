<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\Decorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticAwsDecorator;

    public function setThrowableDiagnosticAwsDecorator(DecoratorInterface $AwsDecorator): self
    {
        if ($this->hasThrowableDiagnosticAwsDecorator()) {
            throw new LogicException('ThrowableDiagnosticAwsDecorator is already set.');
        }
        $this->ThrowableDiagnosticAwsDecorator = $AwsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticAwsDecorator(): DecoratorInterface
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

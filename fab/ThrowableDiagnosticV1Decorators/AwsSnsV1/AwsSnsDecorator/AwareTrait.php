<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSnsV1\AwsSnsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSnsV1\AwsSnsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator;

    public function setThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator(AwsSnsDecoratorInterface $AwsSnsDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator = $AwsSnsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator(): AwsSnsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsAwsSnsV1AwsSnsDecorator);

        return $this;
    }
}

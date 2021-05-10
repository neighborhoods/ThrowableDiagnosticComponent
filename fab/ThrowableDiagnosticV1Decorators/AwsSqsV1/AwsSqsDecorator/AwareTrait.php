<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSqsV1\AwsSqsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSqsV1\AwsSqsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator;

    public function setThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator(AwsSqsDecoratorInterface $AwsSqsDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator = $AwsSqsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator(): AwsSqsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsAwsSqsV1AwsSqsDecorator);

        return $this;
    }
}

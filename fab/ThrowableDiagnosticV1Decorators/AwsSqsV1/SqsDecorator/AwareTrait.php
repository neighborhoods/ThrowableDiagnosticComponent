<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSqsV1\SqsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSqsV1\SqsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator;

    public function setThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator(SqsDecoratorInterface $SqsDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator = $SqsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator(): SqsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsAwsSqsV1SqsDecorator);

        return $this;
    }
}

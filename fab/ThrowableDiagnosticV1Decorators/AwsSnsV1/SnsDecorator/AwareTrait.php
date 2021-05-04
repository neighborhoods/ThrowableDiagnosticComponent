<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSnsV1\SnsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsSnsV1\SnsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator;

    public function setThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator(SnsDecoratorInterface $SnsDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator = $SnsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator(): SnsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsAwsSnsV1SnsDecorator);

        return $this;
    }
}

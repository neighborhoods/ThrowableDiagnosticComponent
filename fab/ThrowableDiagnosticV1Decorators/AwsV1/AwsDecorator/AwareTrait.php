<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsV1\AwsDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsV1\AwsDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator;

    public function setThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator(AwsDecoratorInterface $AwsDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator = $AwsDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator(): AwsDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsAwsV1AwsDecorator);

        return $this;
    }
}

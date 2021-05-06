<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsS3V1\AwsS3Decorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsS3V1\AwsS3DecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator;

    public function setThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator(AwsS3DecoratorInterface $AwsS3Decorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator = $AwsS3Decorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator(): AwsS3DecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsAwsS3V1AwsS3Decorator);

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\S3Decorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\S3DecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticAwsS3Decorator;

    public function setThrowableDiagnosticAwsS3Decorator(S3DecoratorInterface $S3Decorator): self
    {
        if ($this->hasThrowableDiagnosticAwsS3Decorator()) {
            throw new LogicException('ThrowableDiagnosticAwsS3Decorator is already set.');
        }
        $this->ThrowableDiagnosticAwsS3Decorator = $S3Decorator;

        return $this;
    }

    protected function getThrowableDiagnosticAwsS3Decorator(): S3DecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticAwsS3Decorator()) {
            throw new LogicException('ThrowableDiagnosticAwsS3Decorator is not set.');
        }

        return $this->ThrowableDiagnosticAwsS3Decorator;
    }

    protected function hasThrowableDiagnosticAwsS3Decorator(): bool
    {
        return isset($this->ThrowableDiagnosticAwsS3Decorator);
    }

    protected function unsetThrowableDiagnosticAwsS3Decorator(): self
    {
        if (!$this->hasThrowableDiagnosticAwsS3Decorator()) {
            throw new LogicException('ThrowableDiagnosticAwsS3Decorator is not set.');
        }
        unset($this->ThrowableDiagnosticAwsS3Decorator);

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\GuzzleDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\GuzzleDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticGuzzleDecorator;

    public function setThrowableDiagnosticGuzzleDecorator(GuzzleDecoratorInterface $GuzzleDecorator): self
    {
        if ($this->hasThrowableDiagnosticGuzzleDecorator()) {
            throw new LogicException('ThrowableDiagnosticGuzzleDecorator is already set.');
        }
        $this->ThrowableDiagnosticGuzzleDecorator = $GuzzleDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticGuzzleDecorator(): GuzzleDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticGuzzleDecorator()) {
            throw new LogicException('ThrowableDiagnosticGuzzleDecorator is not set.');
        }

        return $this->ThrowableDiagnosticGuzzleDecorator;
    }

    protected function hasThrowableDiagnosticGuzzleDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticGuzzleDecorator);
    }

    protected function unsetThrowableDiagnosticGuzzleDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticGuzzleDecorator()) {
            throw new LogicException('ThrowableDiagnosticGuzzleDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticGuzzleDecorator);

        return $this;
    }
}

<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\SymfonyHttpClientDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\SymfonyHttpClientDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticSymfonyHttpClientDecorator;

    public function setThrowableDiagnosticSymfonyHttpClientDecorator(SymfonyHttpClientDecoratorInterface $SymfonyHttpClientDecorator): self
    {
        if ($this->hasThrowableDiagnosticSymfonyHttpClientDecorator()) {
            throw new LogicException('ThrowableDiagnosticSymfonyHttpClientDecorator is already set.');
        }
        $this->ThrowableDiagnosticSymfonyHttpClientDecorator = $SymfonyHttpClientDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticSymfonyHttpClientDecorator(): SymfonyHttpClientDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticSymfonyHttpClientDecorator()) {
            throw new LogicException('ThrowableDiagnosticSymfonyHttpClientDecorator is not set.');
        }

        return $this->ThrowableDiagnosticSymfonyHttpClientDecorator;
    }

    protected function hasThrowableDiagnosticSymfonyHttpClientDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticSymfonyHttpClientDecorator);
    }

    protected function unsetThrowableDiagnosticSymfonyHttpClientDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticSymfonyHttpClientDecorator()) {
            throw new LogicException('ThrowableDiagnosticSymfonyHttpClientDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticSymfonyHttpClientDecorator);

        return $this;
    }
}

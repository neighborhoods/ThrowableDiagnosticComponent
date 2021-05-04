<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\SymfonyHttpClientV1\SymfonyHttpClientDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\SymfonyHttpClientV1\SymfonyHttpClientDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator;

    public function setThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator(SymfonyHttpClientDecoratorInterface $SymfonyHttpClientDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator = $SymfonyHttpClientDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator(): SymfonyHttpClientDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsSymfonyHttpClientV1SymfonyHttpClientDecorator);

        return $this;
    }
}

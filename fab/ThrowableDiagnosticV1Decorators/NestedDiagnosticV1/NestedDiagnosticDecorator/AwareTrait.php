<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\NestedDiagnosticV1\NestedDiagnosticDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\NestedDiagnosticV1\NestedDiagnosticDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator;

    public function setThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator(NestedDiagnosticDecoratorInterface $NestedDiagnosticDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator = $NestedDiagnosticDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator(): NestedDiagnosticDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsNestedDiagnosticV1NestedDiagnosticDecorator);

        return $this;
    }
}

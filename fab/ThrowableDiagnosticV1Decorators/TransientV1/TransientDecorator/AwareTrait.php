<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\TransientV1\TransientDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\TransientV1\TransientDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator;

    public function setThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator(TransientDecoratorInterface $TransientDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator = $TransientDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator(): TransientDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsTransientV1TransientDecorator);

        return $this;
    }
}

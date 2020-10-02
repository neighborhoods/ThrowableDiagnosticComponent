<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\TransientDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\TransientDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticTransientDecorator;

    public function setThrowableDiagnosticTransientDecorator(TransientDecoratorInterface $TransientDecorator): self
    {
        if ($this->hasThrowableDiagnosticTransientDecorator()) {
            throw new LogicException('ThrowableDiagnosticTransientDecorator is already set.');
        }
        $this->ThrowableDiagnosticTransientDecorator = $TransientDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticTransientDecorator(): TransientDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticTransientDecorator()) {
            throw new LogicException('ThrowableDiagnosticTransientDecorator is not set.');
        }

        return $this->ThrowableDiagnosticTransientDecorator;
    }

    protected function hasThrowableDiagnosticTransientDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticTransientDecorator);
    }

    protected function unsetThrowableDiagnosticTransientDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticTransientDecorator()) {
            throw new LogicException('ThrowableDiagnosticTransientDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticTransientDecorator);

        return $this;
    }
}

<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\Psr18V1\Psr18Decorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\Psr18V1\Psr18DecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator;

    public function setThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator(Psr18DecoratorInterface $Psr18Decorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator = $Psr18Decorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator(): Psr18DecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsPsr18V1Psr18Decorator);

        return $this;
    }
}

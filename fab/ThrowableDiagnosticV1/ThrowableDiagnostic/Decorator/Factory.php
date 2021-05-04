<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\DecoratorInterface;

class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): DecoratorInterface
    {
        return clone $this->getThrowableDiagnosticV1ThrowableDiagnosticDecorator();
    }
}

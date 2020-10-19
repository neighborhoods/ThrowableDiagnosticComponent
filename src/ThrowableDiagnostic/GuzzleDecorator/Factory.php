<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\GuzzleDecorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator\FactoryInterface;

final class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): DecoratorInterface
    {
        return clone $this->getThrowableDiagnosticGuzzleDecorator();
    }
}

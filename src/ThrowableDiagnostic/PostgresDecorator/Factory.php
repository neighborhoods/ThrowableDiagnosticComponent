<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\PostgresDecorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator\FactoryInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface;

final class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): DecoratorInterface
    {
        return clone $this->getThrowableDiagnosticPostgresDecorator();
    }
}

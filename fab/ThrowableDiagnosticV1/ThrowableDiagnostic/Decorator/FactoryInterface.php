<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\DecoratorInterface;

interface FactoryInterface
{
    public function create(): DecoratorInterface;
}

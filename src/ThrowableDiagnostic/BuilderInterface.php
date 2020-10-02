<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator\FactoryInterface as DecoratorFactoryInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;

interface BuilderInterface
{
    public function build(): ThrowableDiagnosticInterface;

    public function addFactory(DecoratorFactoryInterface $decoratorFactory): BuilderInterface;
}

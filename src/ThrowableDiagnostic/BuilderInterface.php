<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator\FactoryInterface as DecoratorFactoryInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;

interface BuilderInterface
{
    public function build(): ThrowableDiagnosticInterface;

    public function addFactory(DecoratorFactoryInterface $decoratorFactory): BuilderInterface;
}

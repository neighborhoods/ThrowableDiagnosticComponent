<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;

// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Decorator\FactoryInterface as DecoratorFactoryInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;

interface BuilderInterface
{
    public function build(): ThrowableDiagnosticInterface;

    public function addFactory(DecoratorFactoryInterface $decoratorFactory): BuilderInterface;
}

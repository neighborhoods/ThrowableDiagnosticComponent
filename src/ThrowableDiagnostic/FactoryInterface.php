<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;

interface FactoryInterface
{
    public function create(): ThrowableDiagnosticInterface;
}

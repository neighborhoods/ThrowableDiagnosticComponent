<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\BuilderInterface;

interface FactoryInterface
{
    public function create(): BuilderInterface;
}

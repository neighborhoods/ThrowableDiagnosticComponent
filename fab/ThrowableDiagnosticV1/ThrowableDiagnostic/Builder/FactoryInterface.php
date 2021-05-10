<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Builder;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\BuilderInterface;

interface FactoryInterface
{
    public function create(): BuilderInterface;
}

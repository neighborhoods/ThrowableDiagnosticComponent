<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1;

use Throwable;

interface ThrowableDiagnosticInterface
{
    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface;
}

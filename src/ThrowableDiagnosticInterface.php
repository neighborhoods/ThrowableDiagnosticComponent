<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use Throwable;

interface ThrowableDiagnosticInterface
{
    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface;
}

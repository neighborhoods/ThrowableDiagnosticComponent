<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;

interface DecoratorInterface extends ThrowableDiagnosticInterface
{
    public function setThrowableDiagnostic(ThrowableDiagnosticInterface $ThrowableDiagnostic);
}

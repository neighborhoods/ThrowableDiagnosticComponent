<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;

interface DecoratorInterface extends ThrowableDiagnosticInterface
{
    public function setThrowableDiagnosticV1ThrowableDiagnostic(ThrowableDiagnosticInterface $ThrowableDiagnostic);
}

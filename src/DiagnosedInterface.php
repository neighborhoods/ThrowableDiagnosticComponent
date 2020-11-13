<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use Neighborhoods\ExceptionComponent\ExceptionInterface;

interface DiagnosedInterface extends ExceptionInterface
{
    public function setTransient(bool $transient): DiagnosedInterface;
    public function isTransient(): bool;
}

<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use Neighborhoods\ExceptionComponent\ExceptionInterface;

interface DiagnosisInterface extends ExceptionInterface
{
    public function setTransient(bool $transient): DiagnosisInterface;
    public function isTransient(): bool;
}

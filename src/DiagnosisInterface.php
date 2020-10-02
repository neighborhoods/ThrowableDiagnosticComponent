<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use Throwable;

interface DiagnosisInterface extends Throwable
{
    public function setTransient(bool $transient): DiagnosisInterface;
    public function isTransient(): bool;
    public function setThrowable(Throwable $throwable): DiagnosisInterface;
    public function getThrowable(): Throwable;
}

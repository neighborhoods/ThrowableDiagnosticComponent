<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;

interface FactoryInterface
{
    public function create(): DiagnosisInterface;
}

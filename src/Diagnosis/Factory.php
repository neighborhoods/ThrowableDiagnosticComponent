<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;

class Factory implements FactoryInterface
{
    public function create(): DiagnosisInterface
    {
        return new Diagnosis;
    }
}

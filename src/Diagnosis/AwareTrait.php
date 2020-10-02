<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;

trait AwareTrait
{
    protected $Diagnosis;

    public function setDiagnosis(DiagnosisInterface $Diagnosis): self
    {
        if ($this->hasDiagnosis()) {
            throw new LogicException('Diagnosis is already set.');
        }
        $this->Diagnosis = $Diagnosis;

        return $this;
    }

    protected function getDiagnosis(): DiagnosisInterface
    {
        if (!$this->hasDiagnosis()) {
            throw new LogicException('Diagnosis is not set.');
        }

        return $this->Diagnosis;
    }

    protected function hasDiagnosis(): bool
    {
        return isset($this->Diagnosis);
    }

    protected function unsetDiagnosis(): self
    {
        if (!$this->hasDiagnosis()) {
            throw new LogicException('Diagnosis is not set.');
        }
        unset($this->Diagnosis);

        return $this;
    }
}

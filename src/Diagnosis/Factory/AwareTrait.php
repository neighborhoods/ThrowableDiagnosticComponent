<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosis\Factory;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis\FactoryInterface;

trait AwareTrait
{
    protected $DiagnosisFactory;

    public function setDiagnosisFactory(FactoryInterface $DiagnosisFactory): self
    {
        if ($this->hasDiagnosisFactory()) {
            throw new LogicException('DiagnosisFactory is already set.');
        }
        $this->DiagnosisFactory = $DiagnosisFactory;

        return $this;
    }

    protected function getDiagnosisFactory(): FactoryInterface
    {
        if (!$this->hasDiagnosisFactory()) {
            throw new LogicException('DiagnosisFactory is not set.');
        }

        return $this->DiagnosisFactory;
    }

    protected function hasDiagnosisFactory(): bool
    {
        return isset($this->DiagnosisFactory);
    }

    protected function unsetDiagnosisFactory(): self
    {
        if (!$this->hasDiagnosisFactory()) {
            throw new LogicException('DiagnosisFactory is not set.');
        }
        unset($this->DiagnosisFactory);

        return $this;
    }
}

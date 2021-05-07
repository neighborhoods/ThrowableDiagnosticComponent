<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\ReportToDatadogDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\ReportToDatadogDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticReportToDatadogDecorator;

    public function setThrowableDiagnosticReportToDatadogDecorator(
        ReportToDatadogDecoratorInterface $ReportToDatadogDecorator
    ): self {
        if ($this->hasThrowableDiagnosticReportToDatadogDecorator()) {
            throw new LogicException('ThrowableDiagnosticReportToDatadogDecorator is already set.');
        }
        $this->ThrowableDiagnosticReportToDatadogDecorator = $ReportToDatadogDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticReportToDatadogDecorator(): ReportToDatadogDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticReportToDatadogDecorator()) {
            throw new LogicException('ThrowableDiagnosticReportToDatadogDecorator is not set.');
        }

        return $this->ThrowableDiagnosticReportToDatadogDecorator;
    }

    protected function hasThrowableDiagnosticReportToDatadogDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticReportToDatadogDecorator);
    }

    protected function unsetThrowableDiagnosticReportToDatadogDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticReportToDatadogDecorator()) {
            throw new LogicException('ThrowableDiagnosticReportToDatadogDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticReportToDatadogDecorator);

        return $this;
    }
}

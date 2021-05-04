<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;

class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): ThrowableDiagnosticInterface
    {
        return clone $this->getThrowableDiagnosticV1ThrowableDiagnostic();
    }
}

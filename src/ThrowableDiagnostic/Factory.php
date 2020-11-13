<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;

final class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): ThrowableDiagnosticInterface
    {
        return clone $this->getThrowableDiagnostic();
    }
}

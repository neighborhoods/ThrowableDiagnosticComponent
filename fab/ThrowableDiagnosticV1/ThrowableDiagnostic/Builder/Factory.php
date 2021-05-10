<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Builder;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\BuilderInterface;

class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): BuilderInterface
    {
        return clone $this->getThrowableDiagnosticV1ThrowableDiagnosticBuilder();
    }
}

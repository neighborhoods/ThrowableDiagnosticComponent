<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\BuilderInterface;

final class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): BuilderInterface
    {
        return clone $this->getThrowableDiagnosticBuilder();
    }
}

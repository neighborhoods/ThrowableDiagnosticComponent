<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;

final class Factory implements FactoryInterface
{
    public function create(): DiagnosedInterface
    {
        return new Diagnosed();
    }
}

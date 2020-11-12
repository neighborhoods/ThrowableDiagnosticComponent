<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;

final class Factory implements FactoryInterface
{
    public function create(): DiagnosedInterface
    {
        return new Diagnosed();
    }
}

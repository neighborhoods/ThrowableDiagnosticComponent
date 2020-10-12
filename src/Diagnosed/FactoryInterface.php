<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;

interface FactoryInterface
{
    public function create(): DiagnosedInterface;
}

<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\S3Decorator;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator\FactoryInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface;

class Factory implements FactoryInterface
{
    use AwareTrait;

    public function create(): DecoratorInterface
    {
        return clone $this->getThrowableDiagnosticAwsS3Decorator();
    }
}

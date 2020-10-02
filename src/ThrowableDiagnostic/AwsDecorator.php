<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Aws\Exception\AwsException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Throwable;

class AwsDecorator implements AwsDecoratorInterface
{
    use AwareTrait;
    use Diagnosis\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof AwsException) {
            $transient = $this->isAwsErrorCodeTransient($throwable->getAwsErrorCode());
            throw $this->getDiagnosisFactory()
                ->create()
                ->setTransient($transient)
                ->setThrowable($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }

    public function isAwsErrorCodeTransient(string $errorCode): bool
    {
        $transient = (strpos($errorCode, 'Throttl') !== false);
        $transient |= (strpos($errorCode, 'ServiceUnavailable') !== false);
        $transient |= (strpos($errorCode, 'ConcurrentAccess') !== false);

        return $transient;
    }
}

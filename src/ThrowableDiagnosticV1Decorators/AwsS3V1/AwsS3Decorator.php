<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsS3V1;

use Aws\S3\Exception\S3Exception;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Throwable;

final class AwsS3Decorator implements AwsS3DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof S3Exception) {
            $transient = $throwable->isConnectionError();
            if (!$transient) {
                $errorCode = $throwable->getAwsErrorCode();
                if ($errorCode) {
                    $transient = $this->isAwsErrorCodeTransient($errorCode);
                }
            }
            throw $this->getThrowableDiagnosticV1DiagnosedFactory()
                ->create()
                ->setTransient($transient)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }

    public function isAwsErrorCodeTransient(string $errorCode): bool
    {
        $transient = (strpos($errorCode, 'Throttl') !== false);
        $transient = $transient || (strpos($errorCode, 'ServiceUnavailable') !== false);
        $transient = $transient || (strpos($errorCode, 'ConcurrentAccess') !== false);

        return $transient;
    }
}

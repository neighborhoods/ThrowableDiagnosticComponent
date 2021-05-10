<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsV1;

use Aws\Exception\AwsException;
use Aws\Exception\CredentialsException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Throwable;

final class AwsDecorator implements AwsDecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof CredentialsException) {
            // Check if retrieving credentials timed out
            // by checking if message has a specific start
            // @codingStandardsIgnoreLine Line below exceeds 120 characters
            if (strpos($throwable->getMessage(), "Error retrieving credentials from the instance profile metadata service.") === 0) {
                throw $this->getThrowableDiagnosticV1DiagnosedFactory()
                    ->create()
                    ->setTransient(true)
                    ->setPrevious($throwable);
            }
        }
        if ($throwable instanceof AwsException) {
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

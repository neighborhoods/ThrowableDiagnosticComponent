<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws;

use Aws\Exception\AwsException;
use Aws\Exception\CredentialsException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Throwable;

final class Decorator implements DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof CredentialsException) {
            // Check if retrieving credentials timed out
            // by checking if message has a specific start
            if (strpos($throwable->getMessage(), "Error retrieving credentials from the instance profile metadata service.") === 0) {
                throw $this->getDiagnosedFactory()
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
            throw $this->getDiagnosedFactory()
                ->create()
                ->setTransient($transient)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

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

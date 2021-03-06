<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\GuzzleV1;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Throwable;

final class GuzzleDecorator implements GuzzleDecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        $isTransient = false;

        // networking error (connection timeout, DNS errors, etc.)
        // Don't use instaceof, because other exceptions extend this one.
        if (get_class($throwable) === RequestException::class) {
            $isTransient = true;
        }
        // networking error
        if ($throwable instanceof ConnectException) {
            $isTransient = true;
        }
        // Server error 503 means service is temporarily unavailable.
        if ($throwable instanceof ServerException) {
            if ($throwable->getResponse()->getStatusCode() === 503) {
                $isTransient = true;
            }
        }
        // Client error 429 means too many requests.
        if ($throwable instanceof ClientException) {
            if ($throwable->getResponse()->getStatusCode() === 429) {
                $isTransient = true;
            }
        }
        if ($isTransient) {
            throw $this->getThrowableDiagnosticV1DiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

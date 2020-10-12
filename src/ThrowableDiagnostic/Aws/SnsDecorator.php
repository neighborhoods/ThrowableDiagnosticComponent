<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws;

use Aws\Sns\Exception\SnsException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Throwable;

final class SnsDecorator implements SnsDecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof SnsException) {
            $transient = $this->isAwsErrorCodeTransient($throwable->getAwsErrorCode());
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
        $transient |= (strpos($errorCode, 'ServiceUnavailable') !== false);
        $transient |= (strpos($errorCode, 'ConcurrentAccess') !== false);

        return $transient;
    }
}

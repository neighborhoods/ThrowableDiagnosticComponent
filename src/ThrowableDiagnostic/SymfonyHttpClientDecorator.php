<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

final class SymfonyHttpClientDecorator implements SymfonyHttpClientDecoratorInterface
{
    use AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        $transient = $throwable instanceof TransportExceptionInterface;
        // Server error 503 means service is temporarily unavailable.
        if (!$transient && $throwable instanceof ServerExceptionInterface) {
            if ($throwable->getResponse()->getStatusCode() === 503) {
                $transient = true;
            }
        }
        // Client error 429 means too many request, retry later
        if (!$transient && $throwable instanceof ClientExceptionInterface) {
            if ($throwable->getResponse()->getStatusCode() === 429) {
                $transient = true;
            }
        }
        if ($transient) {
            throw $this->getDiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

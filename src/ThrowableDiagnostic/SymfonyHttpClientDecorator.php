<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

final class SymfonyHttpClientDecorator implements SymfonyHttpClientDecoratorInterface
{
    use AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // Server error 503 means service is temporarily unavailable.
        if ($throwable instanceof ServerExceptionInterface) {
            if ($throwable->getResponse()->getStatusCode() === 503) {
                throw $this->getDiagnosedFactory()
                    ->create()
                    ->setTransient(true)
                    ->setPrevious($throwable);
            }
        }
        if ($throwable instanceof TransportExceptionInterface) {
            throw $this->getDiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

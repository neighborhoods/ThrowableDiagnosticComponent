<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Throwable;

class SymfonyHttpClientDecorator implements SymfonyHttpClientDecoratorInterface
{
    use AwareTrait;
    use Diagnosis\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof TransportExceptionInterface) {
            throw $this->getDiagnosisFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}

<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Throwable;

final class Psr18Decorator implements Psr18DecoratorInterface
{
    use AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        $transient = $throwable instanceof NetworkExceptionInterface;
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

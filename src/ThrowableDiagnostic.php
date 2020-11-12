<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use LogicException;
use Throwable;

final class ThrowableDiagnostic implements ThrowableDiagnosticInterface
{
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // Prevent wrapping of Diagnosed in another Diagnosed.
        if ($throwable instanceof DiagnosedInterface) {
            throw new LogicException('Nested diagnostic detected.', 0, $throwable);
        }

        // By default consider Throwable non transient.
        throw $this->getDiagnosedFactory()
            ->create()
            ->setTransient(false)
            ->setPrevious($throwable);

        return $this;
    }
}

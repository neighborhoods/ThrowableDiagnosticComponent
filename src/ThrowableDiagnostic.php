<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent;

use LogicException;
use Throwable;

class ThrowableDiagnostic implements ThrowableDiagnosticInterface
{
    use Diagnosis\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // Prevent wrapping of diagnosis is another diagnosis.
        if ($throwable instanceof DiagnosisInterface) {
            throw new LogicException('Nested diagnostic detected.', 0, $throwable);
        }

        // By default consider Throwable non transient.
        throw $this->getDiagnosisFactory()
            ->create()
            ->setTransient(false)
            ->setPrevious($throwable);

        return $this;
    }
}

<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\RetryableException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;
use PDOException;
use Throwable;

final class PostgresDecorator implements PostgresDecoratorInterface
{
    const TRANSIENT_SQL_STATES = [
        '40001',
        '40P01',
        '57014',
        '08001',
        '08006',
    ];
    const TRANSIENT_SQL_STATE_MESSAGES = [
        'HY000' => [
            'server closed the connection unexpectedly',
        ],
    ];

    use AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof PDOException) {
            $this->throwPDODiagnosed($throwable);
        }
        if ($throwable instanceof DBALException) {
            $this->throwDBALDiagnosed($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);
        return $this;
    }

    private function throwPDODiagnosed(PDOException $PDOException): ThrowableDiagnosticInterface
    {
        throw $this->diagnoseFromExceptionMessage($PDOException->getMessage())
            ->setPrevious($PDOException);

        return $this;
    }

    private function throwDBALDiagnosed(DBALException $DBALException): ThrowableDiagnosticInterface
    {
        $exceptionMessage = $DBALException->getMessage();
        $PDOExceptionMessageStart = strpos($exceptionMessage, 'SQLSTATE[');
        if ($PDOExceptionMessageStart !== false) {
            throw $this->diagnoseFromExceptionMessage(substr($exceptionMessage, $PDOExceptionMessageStart))
                ->setPrevious($DBALException);
        }
        // If the exception has an SQLSTATE, let the
        throw $this->getDiagnosedFactory()
            ->create()
            ->setTransient($DBALException instanceof RetryableException)
            ->setPrevious($DBALException);

        return $this;
    }

    private function diagnoseFromExceptionMessage(string $exceptionMessage): DiagnosedInterface
    {
        $transient = false;

        $sqlState = $this->getSqlState($exceptionMessage);
        // Check if SQL State is (always) transient.
        if (in_array($sqlState, static::TRANSIENT_SQL_STATES, true)) {
            $transient = true;
        }
        // Check if SQL State is sometimes transient.
        if (isset(static::TRANSIENT_SQL_STATE_MESSAGES[$sqlState])) {
            // Use exception message to determine if transient.
            foreach (static::TRANSIENT_SQL_STATE_MESSAGES[$sqlState] as $transientMessage) {
                if (str_contains($exceptionMessage, $transientMessage)) {
                    $transient = true;
                    break;
                }
            }
        }

        return $this->getDiagnosedFactory()
            ->create()
            ->setTransient($transient);
    }

    private function getSqlState(string $exceptionMessage): string
    {
        return substr($exceptionMessage, 9/*strlen('SQLSTATE[')*/, 5);
    }
}

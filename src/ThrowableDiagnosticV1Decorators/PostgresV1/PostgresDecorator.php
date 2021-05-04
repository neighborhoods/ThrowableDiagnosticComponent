<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\PostgresV1;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\RetryableException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;
use PDOException;
use Throwable;

final class PostgresDecorator implements PostgresDecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

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

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof PDOException) {
            $this->throwPDODiagnosed($throwable);
        }
        if ($throwable instanceof DBALException) {
            $this->throwDBALDiagnosed($throwable);
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);
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
        throw $this->getThrowableDiagnosticV1DiagnosedFactory()
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

        return $this->getThrowableDiagnosticV1DiagnosedFactory()
            ->create()
            ->setTransient($transient);
    }

    private function getSqlState(string $exceptionMessage): string
    {
        return substr($exceptionMessage, 9/*strlen('SQLSTATE[')*/, 5);
    }
}

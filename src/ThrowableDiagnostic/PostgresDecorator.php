<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Exception\RetryableException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;
use PDOException;
use Throwable;

class PostgresDecorator implements PostgresDecoratorInterface
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
    use Diagnosis\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        if ($throwable instanceof PDOException) {
            $this->throwPDODiagnosis($throwable);
        }
        if ($throwable instanceof DBALException) {
            $this->throwDBALDiagnosis($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);
        return $this;
    }

    private function throwPDODiagnosis(PDOException $PDOException): ThrowableDiagnosticInterface
    {
        throw $this->diagnoseFromExceptionMessage($PDOException->getMessage())
            ->setPrevious($PDOException);

        return $this;
    }

    private function throwDBALDiagnosis(DBALException $DBALException): ThrowableDiagnosticInterface
    {
        $exceptionMessage = $DBALException->getMessage();
        $PDOExceptionMessageStart = strpos($exceptionMessage, 'SQLSTATE[');
        if ($PDOExceptionMessageStart !== false) {
            throw $this->diagnoseFromExceptionMessage(substr($exceptionMessage, $PDOExceptionMessageStart))
                ->setPrevious($DBALException);
        }
        // If the exception has an SQLSTATE, let the
        throw $this->getDiagnosisFactory()
            ->create()
            ->setTransient($DBALException instanceof RetryableException)
            ->setPrevious($DBALException);

        return $this;
    }

    public function diagnoseFromExceptionMessage(string $exceptionMessage): DiagnosisInterface
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

        return $this->getDiagnosisFactory()
            ->create()
            ->setTransient($transient);
    }

    private function getSqlState(string $exceptionMessage): string
    {
        return substr($exceptionMessage, 9/*strlen('SQLSTATE[')*/, 5);
    }
}

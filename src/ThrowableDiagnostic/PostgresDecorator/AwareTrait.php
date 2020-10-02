<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\PostgresDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\PostgresDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticPostgresDecorator;

    public function setThrowableDiagnosticPostgresDecorator(PostgresDecoratorInterface $PostgresDecorator): self
    {
        if ($this->hasThrowableDiagnosticPostgresDecorator()) {
            throw new LogicException('ThrowableDiagnosticPostgresDecorator is already set.');
        }
        $this->ThrowableDiagnosticPostgresDecorator = $PostgresDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticPostgresDecorator(): PostgresDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticPostgresDecorator()) {
            throw new LogicException('ThrowableDiagnosticPostgresDecorator is not set.');
        }

        return $this->ThrowableDiagnosticPostgresDecorator;
    }

    protected function hasThrowableDiagnosticPostgresDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticPostgresDecorator);
    }

    protected function unsetThrowableDiagnosticPostgresDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticPostgresDecorator()) {
            throw new LogicException('ThrowableDiagnosticPostgresDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticPostgresDecorator);

        return $this;
    }
}

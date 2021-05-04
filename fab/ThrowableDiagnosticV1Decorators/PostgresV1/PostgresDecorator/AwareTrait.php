<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\PostgresV1\PostgresDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\PostgresV1\PostgresDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator;

    public function setThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator(PostgresDecoratorInterface $PostgresDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator = $PostgresDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator(): PostgresDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsPostgresV1PostgresDecorator);

        return $this;
    }
}

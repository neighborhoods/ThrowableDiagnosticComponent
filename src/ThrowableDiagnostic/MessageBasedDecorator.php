<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Throwable;

class MessageBasedDecorator implements MessageBasedDecoratorInterface
{
    use AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    private /*string*/ $messagePart;
    private /*bool*/ $transient;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // Check if exception message contains message part
        if (strpos($throwable->getMessage(), $this->getMessagePart()) !== false) {
            throw $this->getDiagnosedFactory()
                ->create()
                ->setTransient($this->isTransient())
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }

    public function setMessagePart(string $messagePart): MessageBasedDecoratorInterface
    {
        if (isset($this->messagePart)) {
            throw new LogicException('Message Part is already set.');
        }
        $this->messagePart = $messagePart;
        return $this;
    }

    public function setTransient(bool $transient): MessageBasedDecoratorInterface
    {
        if (isset($this->transient)) {
            throw new LogicException('Transient is already set.');
        }
        $this->transient = $transient;
        return $this;
    }

    private function getMessagePart(): string
    {
        if (!isset($this->messagePart)) {
            throw new LogicException('Message Part has not been set.');
        }
        return $this->messagePart;
    }

    private function isTransient(): bool
    {
        if (!isset($this->transient)) {
            throw new LogicException('Transient has not been set.');
        }
        return $this->transient;
    }

}

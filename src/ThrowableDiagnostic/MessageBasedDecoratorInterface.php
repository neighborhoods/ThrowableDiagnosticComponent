<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

interface MessageBasedDecoratorInterface extends DecoratorInterface
{
    public function setMessagePart(string $messagePart): MessageBasedDecoratorInterface;
    public function setTransient(bool $transient): MessageBasedDecoratorInterface;
}

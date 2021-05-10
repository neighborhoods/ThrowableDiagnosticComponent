<?php
declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\GuzzleV1\GuzzleDecorator;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\GuzzleV1\GuzzleDecoratorInterface;

trait AwareTrait
{
    protected $ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator;

    public function setThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator(GuzzleDecoratorInterface $GuzzleDecorator): self
    {
        if ($this->hasThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator is already set.');
        }
        $this->ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator = $GuzzleDecorator;

        return $this;
    }

    protected function getThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator(): GuzzleDecoratorInterface
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator is not set.');
        }

        return $this->ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator;
    }

    protected function hasThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator(): bool
    {
        return isset($this->ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator);
    }

    protected function unsetThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator(): self
    {
        if (!$this->hasThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator()) {
            throw new LogicException('ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator is not set.');
        }
        unset($this->ThrowableDiagnosticV1DecoratorsGuzzleV1GuzzleDecorator);

        return $this;
    }
}

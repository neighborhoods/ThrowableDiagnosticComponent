<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Decorator\FactoryInterface as DecoratorFactoryInterface;

final class Builder implements BuilderInterface
{
    use Factory\AwareTrait;

    protected /*array*/ $decoratorFactories = [];

    public function build(): ThrowableDiagnosticInterface
    {
        $ThrowableDiagnostic = $this->getThrowableDiagnosticV1ThrowableDiagnosticFactory()
            ->create();

        foreach ($this->decoratorFactories as $decoratorFactory) {
            $ThrowableDiagnostic = $decoratorFactory
                ->create()
                ->setThrowableDiagnosticV1ThrowableDiagnostic($ThrowableDiagnostic);
        }

        return $ThrowableDiagnostic;
    }

    public function addFactory(DecoratorFactoryInterface $decoratorFactory): BuilderInterface
    {
        $factoryKey = str_replace('\\', '', get_class($decoratorFactory));
        if (isset($this->decoratorFactories[$factoryKey])) {
            throw new LogicException(sprintf('Factory with key, "%s", is already set.', $factoryKey));
        }
        $this->decoratorFactories[$factoryKey] = $decoratorFactory;

        return $this;
    }
}

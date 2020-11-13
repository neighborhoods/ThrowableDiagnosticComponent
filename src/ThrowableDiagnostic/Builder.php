<?php

declare(strict_types=1);

namespace Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;

use LogicException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator\FactoryInterface as DecoratorFactoryInterface;

final class Builder implements BuilderInterface
{
    use Factory\AwareTrait;

    protected /*array*/ $decoratorFactories = [];

    public function build(): ThrowableDiagnosticInterface
    {
        $ThrowableDiagnostic = $this->getThrowableDiagnosticFactory()
            ->create();

        foreach ($this->decoratorFactories as $decoratorFactory) {
            $ThrowableDiagnostic = $decoratorFactory
                ->create()
                ->setThrowableDiagnostic($ThrowableDiagnostic);
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

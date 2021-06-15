# Throwable Diagnostic V1

The `ThrowableDiagnostic` can determine if a `Throwable` happened because of a permanent or transient fault (network issues, database down, 3rd party service unavailable).

Every `Throwable` is by default considered permanent, but certain `Throwables` are known to be transient. By decorating the `ThrowableDiagnostic` with custom diagnostic logic such cases can be identified.

`Decorators` for common cases like RDBMS and AWS are available out of the box. Implementing your own `Decorator` is straightforward. Build a decorator stack tailored to your needs and handle transient `Throwables` properly.

## Predefined decorators

Following decorators are available out of the box.
* [AwsS3V1](../ThrowableDiagnosticV1Decorators/AwsS3V1/README.md)
* [AwsSnsV1](../ThrowableDiagnosticV1Decorators/AwsSnsV1/README.md)
* [AwsSqsV1](../ThrowableDiagnosticV1Decorators/AwsSqsV1/README.md)
* [AwsV1](../ThrowableDiagnosticV1Decorators/AwsV1/README.md)
* [GuzzleV1](../ThrowableDiagnosticV1Decorators/GuzzleV1/README.md)
* [NestedDiagnosticV1](../ThrowableDiagnosticV1Decorators/NestedDiagnosticV1/README.md)
* [PhpUnitV1](../../test/ThrowableDiagnosticV1Decorators/PhpUnitV1/README.md)
* [PostgresV1](../ThrowableDiagnosticV1Decorators/PostgresV1/README.md)
* [Psr18V1](../ThrowableDiagnosticV1Decorators/Psr18V1/README.md)
* [SymfonyHttpClientV1](../ThrowableDiagnosticV1Decorators/SymfonyHttpClientV1/README.md)
* [TransientV1](../ThrowableDiagnosticV1Decorators/TransientV1/README.md)

## Usage

When catching a `Throwable` which might be transient, use the `ThrowableDiagnostic` to `diagnose` it. A `DiagnosedInterface` will be thrown wrapping the original `Throwable`.

```php
<?php

namespace Acme;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Throwable;

class RiskyCode {
    use ThrowableDiagnostic\Builder\Factory\AwareTrait;

    public function run()
    {
        try {
            // Database operations
            // API calls
        } catch (Throwable $throwable) {
            $this->getThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory()
                ->create()
                ->build()
                ->diagnose($throwable);
        }
    }
}
```

Handle the `Throwable` based on the diagnosed.

```php
<?php

namespace Acme;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;
use Throwable;

class AsyncJob {
    public function run()
    {
        try {
            (new RiskyCode())->run();
        } catch (Throwable $throwable) {
            if ($throwable instanceof DiagnosedInterface && $throwable->isTransient()) {
                // Retry later
            } else {
                // Escalate
            }
        }
    }
}
```

Build a decorator stack tailored to your needs. An example is shown below using Symfony services to use the Postgres and AWS decorator.
```yaml
# RiskyCode\ThrowableDiagnostic\Builder.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\BuilderInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Builder
    calls:
      - [ setThrowableDiagnosticFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\FactoryInterface' ] ]
      - [ addFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsV1\AwsDecorator\FactoryInterface' ] ]
      - [ addFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\PostgresV1\PostgresDecorator\FactoryInterface' ] ]
```

Define a `Factory` for the preconfigured builder.

```yaml
# RiskyCode\ThrowableDiagnostic\Builder\Factory.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\Builder\FactoryInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Builder\Factory
    calls:
      - [setThrowableDiagnosticV1ThrowableDiagnosticBuilder, ['@Acme\RiskyCode\ThrowableDiagnostic\BuilderInterface']]
```

Inject the `Factory` into your service.

```yaml
# RiskyCode.service.yml
services:
  Acme\RiskyCode:
    class: Acme\RiskyCode
    calls:
      - [setThrowableDiagnosticV1ThrowableDiagnosticBuilderFactory, ['@Acme\RiskyCode\ThrowableDiagnostic\Builder\FactoryInterface']]
```

## Custom decorator

To properly handle `Throwables` which are specific to your own code, or a package for which a decorator is not available, write your own decorator. To do so extend the `Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\DecoratorInterface` as shown below.
```php
<?php
namespace Acme\RiskyCode\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\DecoratorInterface;
use Throwable;

final class Decorator implements DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // TODO: Implement custom diagnostic logic
        if (false) {
            throw $this->getThrowableDiagnosticV1DiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnosticV1ThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}
```

Use Symfony DI to inject the `Diagnosed` factory.
```yaml
# RiskyCode\ThrowableDiagnostic\Decorator.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\DecoratorInterface:
    class: Acme\RiskyCode\ThrowableDiagnostic\Decorator
    calls:
      - [setDiagnosedFactory, ['@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\Diagnosed\FactoryInterface']]
      # Don't call setThrowableDiagnostic. The ThrowableDiagnostic is injected by the ThrowableDiagnostic builder.
```

Define a decorator `Factory` and add it to your throwable diagnostic builder service.

```yaml
# RiskyCode\ThrowableDiagnostic\Decorator\Factory.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\Decorator\FactoryInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic\Decorator\Factory
    calls:
      - [setThrowableDiagnosticV1ThrowableDiagnosticDecorator, ['@Acme\RiskyCode\ThrowableDiagnostic\DecoratorInterface']]
```

### Unit testing custom decorator

Once the decorator is implemented you might want to test it.  
This package unit tests implemented decorators using traits providing tailored mocks and expectations. The traits are in the `/test` folder. Composer doesn't autoload them by default. To autoload the traits and base class for Decorator tests add the following block to your "autoload-dev" section of `composer.json`:
```json
{
  "autoload-dev": {
    "files": [
      "vendor/neighborhoods/throwable-diagnostic-component/test/ThrowableDiagnosticV1Decorators/ThrowableDiagnosticMockerTrait.php",
      "vendor/neighborhoods/throwable-diagnostic-component/test/ThrowableDiagnosticV1Decorators/DiagnosedFactoryMockerTrait.php",
      "vendor/neighborhoods/throwable-diagnostic-component/test/ThrowableDiagnosticV1Decorators/DecoratorTestCase.php"
    ],
    "psr-4": {
      "AcmeTest\\": [
        "test/"
      ]
    }
  }
}
```
After changing `composer.json` run `composer dump-autoload` for the changes to have effect.

The `DecoratorTestCase` is a [PHPUnit](https://github.com/sebastianbergmann/phpunit) `TestCase` using the `ThrowableDiagnosticMockerTrait` and `DiagnosedFactoryMockerTrait` traits. To make use of them PHPUnit must be a dev-dependency. A wide range of PHPUnit versions should be compatible with the autoloaded code.

The test case for your custom decorator might look along these lines.
```php
<?php

declare(strict_types=1);

namespace AcmeTest\Unit\RiskyCode\ThrowableDiagnostic;

use Acme\RiskyCode\ThrowableDiagnostic\Decorator;
use Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators\DecoratorTestCase;
use Throwable;

class DecoratorTest extends DecoratorTestCase
{
    protected Decorator $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new Decorator();
        $this->decorator
            ->setThrowableDiagnosticV1DiagnosedFactory($this->getThrowableDiagnosticV1DiagnosedFactoryMock())
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticV1ThrowableDiagnosticMock());
    }

    public function testDiagnoseShouldThrowDiagnosedWithTransientException(): void
    {
        // Compose an exception which
        // the decorator is supposed to interpret as transient.
        $transientException = $this->createMock(...);
        // Decorated Throwable Diagnostic shouldn't be used.
        $this->expectNoForwarding();
        // Injected Diagnosed Factory mock should be used
        // to compose a Diagnosed mock expecting previous exception
        // to match transientException and be marked as transient.
        $diagnosedMock = $this->expectDiagnosedCreation($transientException, true);
        // Diagnosed mock is expected to be thrown.
        $this->expectExceptionObject($diagnosedMock);
        $this->decorator->diagnose($transientException);
    }

    public function testForwardsDummyThrowable(): void
    {
        $dummyThrowable = $this->createMock(Throwable::class);
        // Decorated Throwable Diagnostic should be used.
        $this->expectForwarding($dummyThrowable);
        // Injected Diagnosed Factory mock shouldn't be used
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($dummyThrowable);
    }
}
```

## Buphalo integration

[Buphalo](https://github.com/neighborhoods/Buphalo) templates are available for actors using throwable diagnostic, custom throwable diagnostic decorators as well as their accompanying files.

To use the buphalo templates follow the steps explained [here](../../README.md).

### Decorator stack fabrication

Create the file `RiskyCode.buphalo.v1.fabrication.yml` if it doesn't already exist and make sure it has the following lines.

```yaml
actors:
  <PrimaryActorName>/ThrowableDiagnostic/Builder.service.yml:
    template: ThrowableDiagnosticComponent/ThrowableDiagnosticV1/DiagnoserV1/PrimaryActorName/ThrowableDiagnostic/Builder.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/Builder/Factory.service.yml:
    template: ThrowableDiagnosticComponent/ThrowableDiagnosticV1/DiagnoserV1/PrimaryActorName/ThrowableDiagnostic/Builder/Factory.service.yml
```

Modify the generated `Builder.service.yml` to composes a decorator stack tailored to `RiskyCode`. Move the file from your fabrication folder to the source folder before doing so.  
You still need to manually inject the fabricated builder factory into the aware service, e.g. `RiskyCode`.

### Custom decorator fabrication

If you also want a custom decorator add the `CustomDecoratorName.buphalo.v1.fabrication.yml` file with the content below. Preferably into the `ThrowableDiagnostic` subdirectory, next to the `Builder.service.yml` using it.

```yaml
actors:
  <PrimaryActorName>.php:
    template: ThrowableDiagnosticComponent/ThrowableDiagnosticV1/DecoratorV1/PrimaryActorName.php
  <PrimaryActorName>.service.yml:
    template: ThrowableDiagnosticComponent/ThrowableDiagnosticV1/DecoratorV1/PrimaryActorName.service.yml
  <PrimaryActorName>Interface.php:
    template: ThrowableDiagnosticComponent/ThrowableDiagnosticV1/DecoratorV1/PrimaryActorNameInterface.php
  <PrimaryActorName>/Factory.php:
    template: ThrowableDiagnosticComponent/ThrowableDiagnosticV1/DecoratorV1/PrimaryActorName/Factory.php
  <PrimaryActorName>/Factory.service.yml:
    template: ThrowableDiagnosticComponent/ThrowableDiagnosticV1/DecoratorV1/PrimaryActorName/Factory.service.yml
```

Move the fabricated `CustomDecoratorName.php` file from your fabrication folder to the source folder and write you custom diagnostic logic. 

#### Decorator implementation templates

Instead of the dummy decorator implementation template, more elaborate implementation templates are available. To use one of them change `DecoratorV1` template path part in the `CustomDecoratorName.buphalo.v1.fabrication.yml` file.

Alternatives include
* **DiagnosingDecoratorV1**  
  Similar to *DecoratorV1*. It's additionally aware of the `Diagnosed` factory, which gets injected.
* **MessageBasedDecoratorV1**  
  Similar to *DecoratorV1*. It contains logic for checking if throwable message contains a specific substring.
* **DiagnosingMessageBasedDecoratorV1**  
  Similar to *MessageBasedDecoratorV1*. It's additionally aware of the `Diagnosed` factory, which gets injected.

## Container Building

When using a Symfony DI based container to resolve a service aware of the `ThrowableDiagnostic` builder factory, make sure it searches the source and fabrication folder of this component version and the used decorators.

```php
// Discover used predefined service definitions
$containerBuilder
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/AwsV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/AwsV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/PostgresV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/PostgresV1'
);
$container = $containerBuilder->build();
$riskyCode = $container->get(RiskyCode::class);

// Risky code is using throwable diagnostic with the decorators
// configured in the corresponding ThrowableDiagnostic builder.
$riskyCode->run();
```

If you are using a [Prefab user-defined subset of containers](https://github.com/neighborhoods/Prefab/tree/feature/container_only#subset-container-buildable-directories) add the directory path filter as shown below.

Prefab global config *http-buildable-directories.yml* in project root
```yaml
ComponentName/DAO:
  buildable_directories:
    - ComponentName
  welcome_baskets:
    - Doctrine\DBAL
    - PDO
    - Opcache
    - NewRelic
    - Zend\Expressive
    - SearchCriteria
 appended_paths:
    - vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1
    - vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1
    - vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/AwsV1
    - vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/AwsV1
    - vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/PostgresV1
    - vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/PostgresV1
```

## PHPUnit integration

Use [PhpUnitV1](../../test/ThrowableDiagnosticV1Decorators/PhpUnitV1/README.md) to integrate with PHPUnit. 

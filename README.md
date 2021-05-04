# Throwable Diagnostic

A Service Agnostic Component for diagnosing `Throwables`. 


The `ThrowableDiagnostic` can determine if a `Throwable` happened because of a permanent or transient fault (network issues, database down, 3rd party service unavailable).


Every `Throwable` is by default considered permanent, but certain `Throwables` are known to be transient. By decorating the `ThrowableDiagnostic` with custom diagnostic logic such cases can be identified.  


`Decorators` for common cases like RDBMS and AWS are available out of the box. Implementing your own `Decorator` is straightforward. Build a decorator stack tailored to your needs and handle transient `Throwables` properly.

## Install

Via Composer

``` bash
$ composer require neighborhoods/throwable-diagnostic-component
```

## Usage

When catching a `Throwable` which might be transient, use the `ThrowableDiagnostic` to `diagnose` it. A `DiagnosedInterface` will be thrown wrapping the original `Throwable`.

``` php
<?php
namespace Acme;

use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Throwable;

class RiskyCode {
    use ThrowableDiagnostic\Builder\Factory\AwareTrait;

    public function run()
    {
        try {
            // Database operations
            // API calls
        } catch (Throwable $throwable) {
            $this->getThrowableDiagnosticBuilderFactory()
                ->create()
                ->build()
                ->diagnose($throwable);
        }
    }
}
```

Handle the `Throwable` based on the diagnosed.

``` php
<?php
namespace Acme;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosedInterface;
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
``` yaml
# RiskyCode\ThrowableDiagnostic\Builder.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\BuilderInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder
    calls:
      - [ setThrowableDiagnosticFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\FactoryInterface' ] ]
      - [ addFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\AWSDecorator\FactoryInterface' ] ]
      - [ addFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\PostgresDecorator\FactoryInterface' ] ]
```

Create a Factory for the preconfigured builder.

``` yaml
# RiskyCode\ThrowableDiagnostic\Builder\Factory.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\Builder\FactoryInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder\Factory
    calls:
      - [setThrowableDiagnosticBuilder, ['@Acme\RiskyCode\ThrowableDiagnostic\BuilderInterface']]
```

Inject the factory into your service.

``` yaml
# RiskyCode.service.yml
services:
  Acme\RiskyCode:
    class: Acme\RiskyCode
    calls:
      - [setThrowableDiagnosticBuilderFactory, ['@Acme\RiskyCode\ThrowableDiagnostic\Builder\FactoryInterface']]
```

## Custom decorator

To properly handle `Throwables` which are specific to your own code or a package for which a decorator is not available, write your own decorator. To do so extend the `Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface` as shown below.
``` php
<?php
namespace Acme\RiskyCode\ThrowableDiagnostic;

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosed;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface;
use Throwable;

final class Decorator implements DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosed\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // TODO: Implement custom diagnostic logic
        if (false) {
            throw $this->getDiagnosedFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}
```

Use Symfony DI to inject the Diagnosed factory.
``` yaml
# RiskyCode\ThrowableDiagnostic\Decorator.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\DecoratorInterface:
    class: Acme\RiskyCode\ThrowableDiagnostic\Decorator
    calls:
      - [setDiagnosedFactory, ['@Neighborhoods\ThrowableDiagnosticComponent\Diagnosed\FactoryInterface']]
      # Don't call setThrowableDiagnostic. The ThrowableDiagnostic is injected by the ThrowableDiagnostic builder.
```

Define a decorator factory and add it to your builder service.

``` yaml
# RiskyCode\ThrowableDiagnostic\Decorator\Factory.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\Decorator\FactoryInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Decorator\Factory
    calls:
      - [setThrowableDiagnosticDecorator, ['@Acme\RiskyCode\ThrowableDiagnostic\DecoratorInterface']]
```

### Unit testing custom decorator

Once the decorator is implemented you might want to test it.  
This package unit tests implemented decorators using traits providing tailored mocks and expectations. The traits are in the `/test` folder. Composer doesn't autoload them by default. To autoload the traits and base class for Decorator tests add the following block to your "autoload-dev" section of `composer.json`:
```json
{
  "autoload-dev": {
    "files": [
      "vendor/neighborhoods/throwable-diagnostic-component/test/Decorator/ThrowableDiagnosticMockerTrait.php",
      "vendor/neighborhoods/throwable-diagnostic-component/test/Decorator/DiagnosedFactoryMockerTrait.php",
      "vendor/neighborhoods/throwable-diagnostic-component/test/Decorator/DecoratorTestCase.php"
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
use Neighborhoods\ThrowableDiagnosticComponentTest\Decorator\DecoratorTestCase;
use Throwable;

class DecoratorTest extends DecoratorTestCase
{
    protected Decorator $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new Decorator();
        $this->decorator
            ->setDiagnosedFactory($this->getDiagnosedFactoryMock())
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
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

[Buphalo](https://github.com/neighborhoods/Buphalo) templates are available for generating custom ThrowableDiagnostic Builders, Builder Factories, Decorators and Decorator files.

### Prerequisites

The Buphalo templates are provided in a custom template tree. Support for multiple template trees has been added to Buphalo in version 1.1. Ensure you have Buphalo version 1.1 or above installed.  
When you run Buphalo you need to add the template tree contained in this package to the template tree directory paths. To do so make an export as shown below.
``` bash
Neighborhoods_Buphalo_V1_TemplateTree_Map_Builder_FactoryInterface__TemplateTreeDirectoryPaths=default:$PWD/vendor/neighborhoods/buphalo/template-tree/V1,diagnostic:$PWD/vendor/neighborhoods/throwable-diagnostic-component/template-tree/BuphaloV1
```

The export above assumes that you have no other custom template trees.

### Decorator stack fabrication

Create the file `RiskyCode.buphalo.v1.fabrication.yml` if it doesn't already exist and make sure it has the following lines.

``` yaml
actors:
  <PrimaryActorName>/ThrowableDiagnostic/Builder.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/Builder/Factory.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder/Factory.service.yml
```

Modify the `PrimaryActorName/ThrowableDiagnostic/Builder.service.yml` to composes a decorator stack tailored to `RiskyCode`. Before doing so move the file from your fabrication folder to the source folder.  
You still need to manually inject the fabricated builder factory into the aware service, e.g. `RiskyCode`.

### Custom decorator fabrication

If you also want a custom decorator add the `CustomDecoratorName.buphalo.v1.fabrication.yml` file with the content below. Preferably into the `ThrowableDiagnostic` subdirectory, next to the `Builder.service.yml` using it.

``` yaml
actors:
  <PrimaryActorName>.php:
    template: ThrowableDiagnostic/Decorator/PrimaryActorName.php
  <PrimaryActorName>.service.yml:
    template: ThrowableDiagnostic/Decorator/PrimaryActorName.service.yml
  <PrimaryActorName>Interface.php:
    template: ThrowableDiagnostic/Decorator/PrimaryActorNameInterface.php
  <PrimaryActorName>/Factory.php:
    template: ThrowableDiagnostic/Decorator/PrimaryActorName/Factory.php
  <PrimaryActorName>/Factory.service.yml:
    template: ThrowableDiagnostic/Decorator/PrimaryActorName/Factory.service.yml
```

Move the `PrimaryActorName/ThrowableDiagnostic/CustomDecoratorName.php` file from your fabrication folder to the source folder and write you custom diagnostic logic. 

#### Decorator implementation templates

Instead of the dummy decorator implementation template, more elaborate implementation templates are available. To use one of them change the template value of the `<PrimaryActorName>.php` in the `CustomDecoratorName.buphalo.v1.fabrication.yml` file.

Alternatives include
* ThrowableDiagnostic/Decorator/MessageBasedDecorator.php

## Protean Container

When using a Symfony DI based container to resolve a service aware of the `ThrowableDiagnostic` builder factory, make sure it searches the source folder of this package.

* For the Protean Container add the directory path filter as shown below.

``` php
$proteanContainerBuilder = new Prefab5\Protean\Container\Builder();
$proteanContainerBuilder->getDiscoverableDirectories()
    ->addDirectoryPathFilter('../vendor/neighborhoods/throwable-diagnostic-component/src');
// Further builder configuration

$proteanContainer = $proteanContainerBuilder->build();
$riskyCode = $proteanContainer->get(RiskyCode::class);

// Risky code is using throwable diagnostic with the decorators
// configured in the corresponding ThrowableDiagnostic builder.
$riskyCode->run();
```

* If you are using a [Prefab user-defined subset of containers](https://github.com/neighborhoods/Prefab/tree/feature/container_only#subset-container-buildable-directories) add the directory path filter as shown below.

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
    - vendor/neighborhoods/throwable-diagnostic-component/src
```


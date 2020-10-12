# Throwable Diagnostic

A diagnostic tool for `Throwables`.  
The `ThrowableDiagnostic` can determine if a `Throwable` happened because of a permanent or transient fault (network issues, database down, 3rd party service unavailable).  
Every `Throwable` is by default considered permanent, but certain `Throwables` are known to be transient. By decorating the `ThrowableDiagnostic` with custom diagnostic logic such cases can be identified.  
`Decorators` for common cases like RDBMS and AWS are available out of the box. Implementing your own `Decorator` is straightforward. Build a decorator stack tailored to your needs and handle transient `Throwables` properly.

## Install

Via Composer

``` bash
$ composer require neighborhoods/throwable-diagnostic-component
```

Since this is a private package, neighborhoods.com must be registered as a composer repository. Make sure your `composer.json` has a `repositories` array in the root object with an item as shown below.

``` json
"repositories": [
    {
      "type": "composer",
      "url": "https://satis.neighborhoods.com"
    }
  ],
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

class Decorator implements DecoratorInterface
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

## Buphalo integration

[Buphalo](https://github.com/neighborhoods/Buphalo) templates are available for generating custom ThrowableDiagnostic Builders, Builder Factories, Decorators and Decorator files.

When you run buphalo you need to add the template tree contained in this package to the template tree directory paths. To do so make an export as shown below.
``` bash
Neighborhoods_Buphalo_V1_TemplateTree_Map_Builder_FactoryInterface__TemplateTreeDirectoryPaths=default:$PWD/vendor/neighborhoods/buphalo/template-tree/V1,diagnostic:$PWD/vendor/neighborhoods/throwable-diagnostic-component/template-tree/V1
```

After that create the file `RiskyCode.buphalo.v1.fabrication.yml` if it doesn't already exist and make sure it has the following lines.

``` yaml
actors:
  <PrimaryActorName>/ThrowableDiagnostic/Builder.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/Builder/Factory.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder/Factory.service.yml
```
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

You need to edit the `PrimaryActorName/ThrowableDiagnostic/Builder.service.yml` and `PrimaryActorName/ThrowableDiagnostic/Decorator.php` files. Before doing so move the files from your fabrication folder to the source folder.

### Protean Container

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
    - ../vendor/neighborhoods/throwable-diagnostic-component/src
    - ComponentName
  welcome_baskets:
    - Doctrine\DBAL
    - PDO
    - Opcache
    - NewRelic
    - Zend\Expressive
    - SearchCriteria
```


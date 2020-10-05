# Throwable Diagnostic

A diagnostic tool for `Throwables`.  
The `ThrowableDiagnostic` can determine if a `Throwable` happened because of a permanent or transient fault (network issues, database down, 3rd party service unavailable).  
Every `Throwable` is by default considered permanent, but certain `Throwables` are known to be transient. By decorating the `ThrowableDiagnostic` with custom diagnostic logic such cases can be identified.  
`Decorators` for common cases like RDBMS and AWS are available out of the box. Implementing your own `Decorator` is straightforward. Build a decorator stack tailored to your needs and handle throwables properly.

## Install

Via Composer

``` bash
$ composer require neighborhoods/ThrowableDiagnosticComponent
```

Since this is a private package, neighborhoods.com must be registered as a composer repository. Make sure your `composer.json` has a `repositories` array in the root object with an item as shown below.

```
"repositories": [
    {
      "type": "composer",
      "url": "https://satis.neighborhoods.com"
    }
  ],
```

## Usage

When catching a `Throwable` which might be transient, use the `ThrowableDiagnostic` to `diagnose` it. A `DiagnosisInterface` will be thrown wrapping the original `Throwable`.

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

Handle the `Throwable` based on the diagnosis.

``` php
<?php
namespace Acme;

use Neighborhoods\ThrowableDiagnosticComponent\DiagnosisInterface;
use Throwable;

class AsyncJob {
    public function run()
    {
        try {
            (new RiskyCode())->run();
        } catch (Throwable $throwable) {
            if ($throwable instanceof DiagnosisInterface && $throwable->isTransient()) {
                // Retry later
            } else {
                // Excalate
            }
        }
    }
}
```

Build a decorator stack tailored to your needs. An example is shown below using Symfony services to use the Postgres and AWS decorator.
```
# RiskyCode\ThrowableDiagnostic\Builder.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\BuilderInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder
    calls:
      - [ setThrowableDiagnosticFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\FactoryInterface' ] ]
      - [ addFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\AWSDecorator\FactoryInterface' ] ]
      - [ addFactory, [ '@Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\PostgresDecorator\FactoryInterface' ] ]
```
```
# RiskyCode\ThrowableDiagnostic\Builder\Factory.service.yml
services:
  Acme\RiskyCode\ThrowableDiagnostic\Builder\FactoryInterface:
    class: Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Builder\Factory
    calls:
      - [setThrowableDiagnosticBuilder, ['@Acme\RiskyCode\ThrowableDiagnostic\BuilderInterface']]
```

```
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

use Neighborhoods\ThrowableDiagnosticComponent\Diagnosis;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticInterface;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\DecoratorInterface;
use Throwable;

class Decorator implements DecoratorInterface
{
    use ThrowableDiagnostic\AwareTrait;
    use Diagnosis\Factory\AwareTrait;

    public function diagnose(Throwable $throwable): ThrowableDiagnosticInterface
    {
        // TODO: Implement custom diagnostic logic
        if (false) {
            throw $this->getDiagnosisFactory()
                ->create()
                ->setTransient(true)
                ->setPrevious($throwable);
        }

        $this->getThrowableDiagnostic()->diagnose($throwable);

        return $this;
    }
}
```

Create a factory for it and add it to your builder service.

```
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

```
actors:
  <PrimaryActorName>/ThrowableDiagnostic/Builder.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/Builder/Factory.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder/Factory.service.yml
```
If you also want a custom decorator make sure it has the following lines.

``` bash
actors:
  <PrimaryActorName>/ThrowableDiagnostic/Builder.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/Builder/Factory.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Builder/Factory.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/Decorator.php:
    template: PrimaryActorName/ThrowableDiagnostic/Decorator.php
  <PrimaryActorName>/Throwa/home/hrvoje/Documents/Yuca/55places/InquiryService/vendor/neighborhoods/throwable-diagnostic-componentbleDiagnostic/Decorator.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Decorator.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/DecoratorInterface.php:
    template: PrimaryActorName/ThrowableDiagnostic/DecoratorInterface.php
  <PrimaryActorName>/ThrowableDiagnostic/Decorator/Factory.service.yml:
    template: PrimaryActorName/ThrowableDiagnostic/Decorator/Factory.service.yml
  <PrimaryActorName>/ThrowableDiagnostic/Decorator/Factory.php:
    template: PrimaryActorName/ThrowableDiagnostic/Decorator/Factory.php
```

You need to edit the `PrimaryActorName/ThrowableDiagnostic/Builder.service.yml` and `PrimaryActorName/ThrowableDiagnostic/Decorator.php` files. Before doing so move the files from your fabrication folder to the source folder.
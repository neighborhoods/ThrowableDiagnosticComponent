# Throwable Diagnostic Component

A Service Agnostic Component for diagnosing `Throwables`. 

The `ThrowableDiagnostic` can determine if a `Throwable` happened because of a permanent or transient fault (network issues, database down, 3rd party service unavailable).

Every `Throwable` is by default considered permanent, but certain `Throwables` are known to be transient. With custom diagnostic logic such cases can be identified.

Diagnostic logic for common cases like RDBMS and AWS are available out of the box. Defining your own diagnostic logic is straightforward.

## Install

Via Composer

```bash
$ composer require neighborhoods/throwable-diagnostic-component
```

### Versioning

Don't confuse releases on [packagist](https://packagist.org/packages/neighborhoods/throwable-diagnostic-component), e.g. 3.0.0, with versions of components contained within this package, e.g. AwsSqsV1. One release may contain multiple versions of the same component.  
Parts of your code may use older versions of components, while others use the latest.

### Upgrade

For upgrading from release 3 to release 4 follow the [Upgrade Guide](docs/UpgradeGuide.md).

## Usage

Components fall into one of two categories
* Throwable Diagnostic
* Throwable Diagnostic Decorator

The Throwable Diagnostic defines the core concept of how this works. The Throwable Diagnostic mostly contains interfaces. It determines how user code diagnoses a Throwable, how the decorators look, and how to define the stack of decorators to be used. You may think of it as a framework/skeleton/scaffolding.  
There might be multiple versions of throwable diagnostic, e.g. ThrowableDiagnosticV1 and ThrowableDiagnosticV2.

A Throwable Diagnostic Decorator is in charge of diagnosing certain `Throwables`. For example, the `GuzzleV1` component has a decorator which decides if an exception originating from guzzle is transient or not. During the diagnostic process a `Throwable` can be inspected by multiple decorators, each of which may decide that the `Throwable` is transient, permanent, or should be passed to the next decorator.
A throwable diagnostic decorator is made for a specific version of Throwable Diagnostic. All decorators compatible with ThrowableDiagnosticV1 are placed in the `src/ThrowableDiagnosticV1Decorators` folder.  
There are decorators for different `Throwables`. Diagnostic logic for certain `Throwables` may have multiple versions, e.g. GuzzleV1, GuzzleV2. Use the latest version if possible.  
You can implement your own decorator to properly handle `Throwables` which are specific to your own code, or a package for which a decorator is not available.

For usage details and list of predefined decorators please refer to the corresponding Throwable Diagnostic version.

* [ThrowableDiagnosticV1](src/ThrowableDiagnosticV1/README.md)

## Buphalo integration

[Buphalo](https://github.com/neighborhoods/Buphalo) templates are available for actors using throwable diagnostic, custom throwable diagnostic decorators as well as their accompanying files.

### Prerequisites

The Buphalo templates are provided in a custom template tree. Support for multiple template trees has been added to Buphalo in version 1.1. Ensure you have Buphalo version 1.1 or above installed.  
You probably have a script in your project's bin folder running `vendor/bin/buphalo` with all the needed environment variables. Edit the environment variable for template tree directory paths to include the template tree contained in this package. The environment variable definition might be as below.
```bash
Neighborhoods_Buphalo_V1_TemplateTree_Map_Builder_FactoryInterface__TemplateTreeDirectoryPaths=default:$PWD/vendor/neighborhoods/buphalo/template-tree/V1,diagnostic:$PWD/vendor/neighborhoods/throwable-diagnostic-component/template-tree/BuphaloV1
```

The export above assumes that you have no other custom template trees.

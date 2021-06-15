# Symfony HTTP Client V1
This Throwable Diagnostic Decorator diagnoses [PSR-18](https://github.com/php-fig/http-client) exceptions.

## Paths
As usual the DI service definition are located in the corresponding source and fabrication subfolders.

Some of these services depend on services defined in ThrowableDiagnosticV1. Therefore, those paths are also required.
```php
$containerBuilder
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/Psr18V1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/Psr18V1');
```

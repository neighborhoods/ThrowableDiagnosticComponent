# Nested Diagnostic V1
This Throwable Diagnostic Decorator prevents already diagnosed exception from reaching the `ThrowableDiagnostic` and a `LogicException` be thrown.

## Paths
As usual the DI service definition are located in the corresponding source and fabrication subfolders.

```php
$containerBuilder
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/NestedDiagnosticV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/NestedDiagnosticV1');
```

# AWS SNS V1
This Throwable Diagnostic Decorator diagnoses AWS SNS specific exceptions.

Since SNS relies on AWS in general the [AwsDecorator](../AwsV1/README.md) has to be also used.

## Paths
As usual the DI service definition are located in the corresponding source and fabrication subfolders.

Some of these services depend on services defined in ThrowableDiagnosticV1. Therefore, those paths are also required.
```php
$containerBuilder
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/AwsSnsV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/AwsSnsV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/fab/ThrowableDiagnosticV1Decorators/AwsV1')
    ->addSourcePath('vendor/neighborhoods/throwable-diagnostic-component/src/ThrowableDiagnosticV1Decorators/AwsV1');
```

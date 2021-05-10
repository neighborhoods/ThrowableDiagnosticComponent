# AWS SQS V1
This Throwable Diagnostic Decorator diagnoses AWS SQS specific exceptions.

Since SQS relies on AWS in general the [AwsDecorator](../AwsV1/README.md) has to be also used.

## Paths
As usual the DI service definition are located in the corresponding source and fabrication subfolders.

Some of these services depend on services defined in ThrowableDiagnosticV1. Therefore, those paths are also required.
```php
$containerBuilder->addSourcePath(
    'vendor/neighborhoods/kojo-worker-decorator-component/fab/ThrowableDiagnosticV1'
);
$containerBuilder->addSourcePath(
    'vendor/neighborhoods/kojo-worker-decorator-component/src/ThrowableDiagnosticV1'
);
$containerBuilder->addSourcePath(
    'vendor/neighborhoods/kojo-worker-decorator-component/fab/ThrowableDiagnosticV1Decorators/AwsSqsV1'
);
$containerBuilder->addSourcePath(
    'vendor/neighborhoods/kojo-worker-decorator-component/src/ThrowableDiagnosticV1Decorators/AwsSqsV1'
);
$containerBuilder->addSourcePath(
    'vendor/neighborhoods/kojo-worker-decorator-component/fab/ThrowableDiagnosticV1Decorators/AwsV1'
);
$containerBuilder->addSourcePath(
    'vendor/neighborhoods/kojo-worker-decorator-component/src/ThrowableDiagnosticV1Decorators/AwsV1'
);
```

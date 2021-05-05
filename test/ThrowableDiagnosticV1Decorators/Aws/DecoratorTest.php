<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators\Aws;

use Aws\Exception\CredentialsException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsV1\AwsDecorator;
use Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators\DecoratorTestCase;
use Throwable;

class DecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new AwsDecorator();
        $this->decorator
            ->setThrowableDiagnosticV1DiagnosedFactory($this->getDiagnosedFactoryMock())
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testDiagnoseThrowsTransientDiagnosedForCredentialTimeout()
    {
        // @codingStandardsIgnoreLine Line below exceeds 120 characters
        $credentialsTimeoutException = new CredentialsException("Error retrieving credentials from the instance profile metadata service. (cURL error 28: Operation timed out after 1001 milliseconds with 0 bytes received (see https://curl.haxx.se/libcurl/c/libcurl-errors.html) for http://169.254.169.254/latest/meta-data/iam/security-credentials/nhds-huddle-service-prod)");
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($credentialsTimeoutException, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($credentialsTimeoutException);
    }

    public function testForwardsDummyThrowable()
    {
        $analysedThrowable = $this->createMock(Throwable::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }
}

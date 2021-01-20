<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\Decorator\Aws;

use Aws\Exception\CredentialsException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\Aws\Decorator;
use Neighborhoods\ThrowableDiagnosticComponentTest\Decorator\DecoratorTestCase;
use Throwable;

class DecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new Decorator();
        $this->decorator
            ->setDiagnosedFactory($this->getDiagnosedFactoryMock())
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testDiagnoseThrowsTransientDiagnosedForCredentialTimeout()
    {
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

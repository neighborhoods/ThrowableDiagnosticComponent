<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use Aws\Exception\CredentialsException;
use Neighborhoods\DependencyInjectionContainerBuilderComponent\TinyContainerBuilder;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\AwsV1\AwsDecorator;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\AnalyzeServiceReferencesPass;
use Symfony\Component\DependencyInjection\Compiler\InlineServiceDefinitionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Throwable;

class AwsDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new AwsDecorator();
        $this->decorator
            ->setThrowableDiagnosticV1DiagnosedFactory($this->getThrowableDiagnosticV1DiagnosedFactoryMock())
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticV1ThrowableDiagnosticMock());
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

    public function testBuildDecoratorFactory(): void
    {
        $rootPath = realpath(dirname(__DIR__, 2));
        if ($rootPath === false) {
            throw new RuntimeException('Absolute path of the root directory not found.');
        }
        $container = (new TinyContainerBuilder())
            ->setContainerBuilder(new ContainerBuilder())
            ->setRootPath($rootPath)
            ->addSourcePath('fab/ThrowableDiagnosticV1')
            ->addSourcePath('src/ThrowableDiagnosticV1')
            ->addSourcePath('fab/ThrowableDiagnosticV1Decorators/AwsV1')
            ->addSourcePath('src/ThrowableDiagnosticV1Decorators/AwsV1')
            ->makePublic(AwsDecorator\Factory::class . 'Interface')
            ->addCompilerPass(new AnalyzeServiceReferencesPass())
            ->addCompilerPass(new InlineServiceDefinitionsPass())
            ->build();

        $result = $container->get(AwsDecorator\Factory::class . 'Interface');
        self::assertNotNull($result);
    }
}

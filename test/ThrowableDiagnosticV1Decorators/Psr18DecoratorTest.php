<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use Neighborhoods\DependencyInjectionContainerBuilderComponent\TinyContainerBuilder;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\Psr18V1\Psr18Decorator;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Client\RequestExceptionInterface;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\AnalyzeServiceReferencesPass;
use Symfony\Component\DependencyInjection\Compiler\InlineServiceDefinitionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Throwable;

class Psr18DecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new Psr18Decorator();
        $this->decorator
            ->setThrowableDiagnosticV1DiagnosedFactory($this->getThrowableDiagnosticV1DiagnosedFactoryMock())
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticV1ThrowableDiagnosticMock());
    }

    public function testClientExceptionInterface()
    {
        $analysedThrowable = $this->createMock(ClientExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testNetworkExceptionInterface()
    {
        $analysedThrowable = $this->createMock(NetworkExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testRequestExceptionInterface()
    {
        $analysedThrowable = $this->createMock(RequestExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
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
            ->addSourcePath('fab/ThrowableDiagnosticV1Decorators/Psr18V1')
            ->addSourcePath('src/ThrowableDiagnosticV1Decorators/Psr18V1')
            ->makePublic(Psr18Decorator\Factory::class . 'Interface')
            ->addCompilerPass(new AnalyzeServiceReferencesPass())
            ->addCompilerPass(new InlineServiceDefinitionsPass())
            ->build();

        $result = $container->get(Psr18Decorator\Factory::class . 'Interface');
        self::assertNotNull($result);
    }
}

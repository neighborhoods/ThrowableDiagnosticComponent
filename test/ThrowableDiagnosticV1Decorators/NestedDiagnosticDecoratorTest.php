<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use Neighborhoods\DependencyInjectionContainerBuilderComponent\TinyContainerBuilder;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\DiagnosedInterface;
// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\NestedDiagnosticV1\NestedDiagnosticDecorator;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\AnalyzeServiceReferencesPass;
use Symfony\Component\DependencyInjection\Compiler\InlineServiceDefinitionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Throwable;
use PHPUnit\Framework\TestCase;

class NestedDiagnosticDecoratorTest extends TestCase
{
    use ThrowableDiagnosticMockerTrait;

    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new NestedDiagnosticDecorator();
        $this->decorator
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticV1ThrowableDiagnosticMock());
    }

    public function testThrowsAnalysedDiagnosed()
    {
        $analysedThrowable = $this->createMock(DiagnosedInterface::class);
        $this->expectNoForwarding();
        $this->expectExceptionObject($analysedThrowable);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testForwardsDummyThrowable()
    {
        $analysedThrowable = $this->createMock(Throwable::class);
        $this->expectForwarding($analysedThrowable);
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
            ->addSourcePath('fab/ThrowableDiagnosticV1Decorators/NestedDiagnosticV1')
            ->addSourcePath('src/ThrowableDiagnosticV1Decorators/NestedDiagnosticV1')
            ->makePublic(NestedDiagnosticDecorator\Factory::class . 'Interface')
            ->addCompilerPass(new AnalyzeServiceReferencesPass())
            ->addCompilerPass(new InlineServiceDefinitionsPass())
            ->build();

        $result = $container->get(NestedDiagnosticDecorator\Factory::class . 'Interface');
        self::assertNotNull($result);
    }
}

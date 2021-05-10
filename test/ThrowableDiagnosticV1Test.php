<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest;

use Neighborhoods\DependencyInjectionContainerBuilderComponent\TinyContainerBuilder;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1\ThrowableDiagnostic;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\AnalyzeServiceReferencesPass;
use Symfony\Component\DependencyInjection\Compiler\InlineServiceDefinitionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ThrowableDiagnosticV1Test extends TestCase
{
    public function testBuildThrowableDiagnosticBuilderFactory(): void
    {
        $rootPath = realpath(dirname(__DIR__));
        if ($rootPath === false) {
            throw new RuntimeException('Absolute path of the root directory not found.');
        }
        $container = (new TinyContainerBuilder())
            ->setContainerBuilder(new ContainerBuilder())
            ->setRootPath($rootPath)
            ->addSourcePath('fab/ThrowableDiagnosticV1')
            ->addSourcePath('src/ThrowableDiagnosticV1')
            ->makePublic(ThrowableDiagnostic\Builder\FactoryInterface::class)
            ->addCompilerPass(new AnalyzeServiceReferencesPass())
            ->addCompilerPass(new InlineServiceDefinitionsPass())
            ->build();

        $result = $container->get(ThrowableDiagnostic\Builder\FactoryInterface::class);
        self::assertNotNull($result);
    }
}

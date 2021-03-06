<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use Neighborhoods\DependencyInjectionContainerBuilderComponent\TinyContainerBuilder;
// @codingStandardsIgnoreLine Line below exceeds 120 characters
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\SymfonyHttpClientV1\SymfonyHttpClientDecorator;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\AnalyzeServiceReferencesPass;
use Symfony\Component\DependencyInjection\Compiler\InlineServiceDefinitionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TimeoutExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class SymfonyHttpClientDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new SymfonyHttpClientDecorator();
        $this->decorator
            ->setThrowableDiagnosticV1DiagnosedFactory($this->getThrowableDiagnosticV1DiagnosedFactoryMock())
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticV1ThrowableDiagnosticMock());
    }

    public function test422ClientExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(422);
        $analysedThrowable = $this->createMock(ClientExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test429ClientExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(429);
        $analysedThrowable = $this->createMock(ClientExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testDecodingExceptionInterface()
    {
        $analysedThrowable = $this->createMock(DecodingExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testExceptionInterface()
    {
        $analysedThrowable = $this->createMock(ExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testHttpExceptionInterface()
    {
        $analysedThrowable = $this->createMock(HttpExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testRedirectionExceptionInterface()
    {
        $analysedThrowable = $this->createMock(RedirectionExceptionInterface::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test500ServerExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(500);
        $analysedThrowable = $this->createMock(ServerExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test503ServerExceptionInterface()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(503);
        $analysedThrowable = $this->createMock(ServerExceptionInterface::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testTimeoutExceptionInterface()
    {
        $analysedThrowable = $this->createMock(TimeoutExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testTransportExceptionInterface()
    {
        $analysedThrowable = $this->createMock(TransportExceptionInterface::class);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
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
            ->addSourcePath('fab/ThrowableDiagnosticV1Decorators/SymfonyHttpClientV1')
            ->addSourcePath('src/ThrowableDiagnosticV1Decorators/SymfonyHttpClientV1')
            ->makePublic(SymfonyHttpClientDecorator\Factory::class . 'Interface')
            ->addCompilerPass(new AnalyzeServiceReferencesPass())
            ->addCompilerPass(new InlineServiceDefinitionsPass())
            ->build();

        $result = $container->get(SymfonyHttpClientDecorator\Factory::class . 'Interface');
        self::assertNotNull($result);
    }
}

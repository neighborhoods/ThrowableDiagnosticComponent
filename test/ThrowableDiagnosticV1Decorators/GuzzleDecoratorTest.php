<?php

namespace Neighborhoods\ThrowableDiagnosticComponentTest\ThrowableDiagnosticV1Decorators;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Neighborhoods\DependencyInjectionContainerBuilderComponent\TinyContainerBuilder;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnosticV1Decorators\GuzzleV1\GuzzleDecorator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Symfony\Component\DependencyInjection\Compiler\AnalyzeServiceReferencesPass;
use Symfony\Component\DependencyInjection\Compiler\InlineServiceDefinitionsPass;
use Throwable;

class GuzzleDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new GuzzleDecorator();
        $this->decorator
            ->setThrowableDiagnosticV1DiagnosedFactory($this->getThrowableDiagnosticV1DiagnosedFactoryMock())
            ->setThrowableDiagnosticV1ThrowableDiagnostic($this->getThrowableDiagnosticV1ThrowableDiagnosticMock());
    }

    public function test422ClientException()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(422);
        $analysedThrowable = $this->createMock(ClientException::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test429ClientException()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(429);
        $analysedThrowable = $this->createMock(ClientException::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test500ServerException()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(500);
        $analysedThrowable = $this->createMock(ServerException::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
        $this->decorator->diagnose($analysedThrowable);
    }

    public function test503ServerException()
    {
        // Compose exception response
        $mockedResponse = $this->createMock(ResponseInterface::class);
        $mockedResponse->expects(self::atLeastOnce())
            ->method('getStatusCode')
            ->willReturn(503);
        $analysedThrowable = $this->createMock(ServerException::class);
        $analysedThrowable->expects(self::atLeastOnce())
            ->method('getResponse')
            ->willReturn($mockedResponse);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testConnectException()
    {
        $analysedThrowable = $this->createMock(ConnectException::class);
        $this->expectNoForwarding();
        $diagnosed = $this->expectDiagnosedCreation($analysedThrowable, true);
        $this->expectExceptionObject($diagnosed);
        $this->decorator->diagnose($analysedThrowable);
    }

    public function testRequestException()
    {
        $analysedThrowable = new RequestException(
            'This cannot be mocked because get_class() is used',
            $this->createMock(RequestInterface::class)
        );
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
            ->setContainerBuilder(new \Symfony\Component\DependencyInjection\ContainerBuilder())
            ->setRootPath($rootPath)
            ->addSourcePath('fab/ThrowableDiagnosticV1')
            ->addSourcePath('src/ThrowableDiagnosticV1')
            ->addSourcePath('fab/ThrowableDiagnosticV1Decorators/GuzzleV1')
            ->addSourcePath('src/ThrowableDiagnosticV1Decorators/GuzzleV1')
            ->makePublic(GuzzleDecorator\Factory::class . 'Interface')
            ->addCompilerPass(new AnalyzeServiceReferencesPass())
            ->addCompilerPass(new InlineServiceDefinitionsPass())
            ->build();

        $result = $container->get(GuzzleDecorator\Factory::class . 'Interface');
        self::assertNotNull($result);
    }
}

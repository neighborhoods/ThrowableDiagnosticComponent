<?php

namespace Test\Decorator;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ServerException;
use Neighborhoods\ThrowableDiagnosticComponent\ThrowableDiagnostic\GuzzleDecorator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class GuzzleDecoratorTest extends DecoratorTestCase
{
    protected $decorator;

    public function setUp(): void
    {
        parent::setUp();

        $this->decorator = new GuzzleDecorator();
        $this->decorator
            ->setDiagnosedFactory($this->getDiagnosedFactoryMock())
            ->setThrowableDiagnostic($this->getThrowableDiagnosticMock());
    }

    public function testClientException()
    {
        $analysedThrowable = $this->createMock(ClientException::class);
        $this->expectForwarding($analysedThrowable);
        $this->expectNoDiagnosedCreation();
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
}

<?php
namespace Payum\Paymill\Tests;

use Payum\Paymill\Api;
use Payum\Core\HttpClientInterface;

class ApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function couldBeConstructedWithOptionsOnly()
    {
        $api = new Api([
            'api_private_key' => 'ApiPrivate',
            'api_public_key' => 'ApiPublic',
            'test_private_key' => 'TestPrivate',
            'test_public_key' => 'TestPublic',
            'sandbox' => true,
        ]);

        $this->assertAttributeInstanceOf('Payum\Core\HttpClientInterface', 'client', $api);
    }

    /**
     * @test
     */
    public function couldBeConstructedWithOptionsAndHttpClient()
    {
        $client = $this->createHttpClientMock();

        $api = new Api([
            'api_private_key' => 'ApiPrivate',
            'api_public_key' => 'ApiPublic',
            'test_private_key' => 'TestPrivate',
            'test_public_key' => 'TestPublic',
            'sandbox' => true,
        ], $client);

        $this->assertAttributeSame($client, 'client', $api);
    }

    /**
     * @test
     *
     * @expectedException \Payum\Core\Exception\LogicException
     * @expectedExceptionMessage The api_private_key fields is not set.
     */
    public function throwIfRequiredOptionsNotSetInConstructor()
    {
        new Api([]);
    }

    /**
     * @test
     *
     * @expectedException \Payum\Core\Exception\LogicException
     * @expectedExceptionMessage The boolean sandbox option must be set.
     */
    public function throwIfSandboxOptionsNotBooleanInConstructor()
    {
        new Api([
            'api_private_key' => 'ApiPrivate',
            'api_public_key' => 'ApiPublic',
            'test_private_key' => 'TestPrivate',
            'test_public_key' => 'TestPublic',
            'sandbox' => 'notABool',
        ]);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|HttpClientInterface
     */
    protected function createHttpClientMock()
    {
        return $this->getMock('Payum\Core\HttpClientInterface');
    }
}

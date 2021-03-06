<?php
namespace Payum\Paymill\Tests;

use Paymill\API\CommunicationAbstract;
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
    public function shouldImplementCommunicationAbstract()
    {
        $rc = new \ReflectionClass(Api::class);

        $this->assertTrue($rc->isSubclassOf(CommunicationAbstract::class));
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

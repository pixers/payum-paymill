<?php
namespace Payum\Paymill;

use GuzzleHttp\Psr7\Request;
use Payum\Core\Bridge\Guzzle\HttpClientFactory;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\Http\HttpException;
use Payum\Core\Exception\LogicException;
use Payum\Core\HttpClientInterface;

class Api
{
    const API_URL = 'https://api.paymill.com/v2.1/';

    /**
     * @var HttpClientInterface
     */
    protected $client;

    /**
     * @var array
     */
    protected $options = [
        'api_private_key' => null,
        'api_public_key' => null,
        'test_private_key' => null,
        'test_public_key' => null,
        'sandbox' => null,
    ];

    /**
     * @param array               $options
     * @param HttpClientInterface $client
     *
     * @throws \Payum\Core\Exception\InvalidArgumentException if an option is invalid
     * @throws \Payum\Core\Exception\LogicException if a sandbox is not boolean
     */
    public function __construct(array $options, HttpClientInterface $client = null)
    {
        $options = ArrayObject::ensureArrayObject($options);

        $options->validateNotEmpty([
            'api_private_key',
            'api_public_key',
            'test_private_key',
            'test_public_key',
        ]);

        if (false == is_bool($options['sandbox'])) {
            throw new LogicException('The boolean sandbox option must be set.');
        }
        $this->options = $options;
        $this->client = $client ?: HttpClientFactory::create();
    }

    public function getPrivateKey()
    {
        return $this->options['sandbox'] ? $this->options['test_private_key'] : $this->options['api_private_key'];
    }

    public function getPublicKey()
    {
        return $this->options['sandbox'] ? $this->options['test_public_key'] : $this->options['api_public_key'];
    }

    /**
     * @param array $fields
     *
     * @return array
     */
    protected function doRequest($method, array $fields)
    {
        $headers = [];

        $request = new Request($method, $this->getApiEndpoint(), $headers, http_build_query($fields));

        $response = $this->client->send($request);

        if (false == ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300)) {
            throw HttpException::factory($request, $response);
        }

        return $response;
    }

    /**
     * @return string
     */
    protected function getApiEndpoint()
    {
        return self::API_URL;
    }
}

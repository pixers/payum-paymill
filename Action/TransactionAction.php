<?php
namespace Payum\Paymill\Action;

use Paymill\Request;
use Paymill\Services\PaymillException;
use Payum\Core\Action\GatewayAwareAction;
use Payum\Core\ApiAwareInterface;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\Exception\LogicException;
use Payum\Core\Exception\RequestNotSupportedException;
use Payum\Core\Exception\UnsupportedApiException;
use Payum\Paymill\Api;
use Payum\Paymill\Request\Transaction;

class TransactionAction extends GatewayAwareAction implements ApiAwareInterface
{
    /**
     * @var Api
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setApi($api)
    {
        if (false == $api instanceof Api) {
            throw new UnsupportedApiException(sprintf('Not supported. Expected %s instance to be set as api.', Api::class));
        }

        $this->api = $api;
    }

    /**
     * {@inheritDoc}
     *
     * @param Transaction $request
     */
    public function execute($request)
    {
        RequestNotSupportedException::assertSupports($this, $request);

        $details = ArrayObject::ensureArrayObject($request->getModel());

        if (!isset($details['token']) || empty($details['token'])) {
            throw new LogicException('The token has to be set.');
        }

        try {
            $transaction = new \Paymill\Models\Request\Transaction();
            $transaction
                ->setAmount($details['amount'])
                ->setCurrency($details['currency'])
                ->setDescription($details['description'])
                ->setToken($details['token']);

            $requestPaymill = new Request();
            $requestPaymill->setConnectionClass($this->api);
            $requestPaymill->create($transaction);

            $responsePaymill = $requestPaymill->getLastResponse();

            $details['http_status_code'] = 200;
            $details['transaction'] = $responsePaymill['body']['data'];
        } catch (PaymillException $e) {
            $details['http_status_code'] = $e->getStatusCode();
            $details['error'] = $e->getResponseCode();
            $details['errorMessage'] = $e->getMessage();
            $details['errorResponse'] = $e->getRawObject();
        }

        $request->setModel($details);
    }

    /**
     * {@inheritDoc}
     */
    public function supports($request)
    {
        return
            $request instanceof Transaction &&
            $request->getModel() instanceof \ArrayAccess
        ;
    }
}

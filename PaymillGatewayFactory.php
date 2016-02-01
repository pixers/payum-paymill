<?php
namespace Payum\Paymill;

use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;
use Payum\Paymill\Action\ConvertPaymentAction;
use Payum\Paymill\Action\CaptureAction;
use Payum\Paymill\Action\StatusAction;
use Payum\Paymill\Action\TransactionAction;

class PaymillGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'payum.factory_name' => 'paymill',
            'payum.factory_title' => 'Paymill',
            'payum.action.capture' => new CaptureAction(),
            'payum.action.transaction' => new TransactionAction(),
            'payum.action.status' => new StatusAction(),
            'payum.action.convert_payment' => new ConvertPaymentAction(),
        ]);

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
                'api_private_key' => '',
                'api_public_key' => '',
                'test_private_key' => '',
                'test_public_key' => '',
                'sandbox' => true,
            );
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = [];

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                return new Api((array) $config, $config['payum.http_client']);
            };
        }
    }
}

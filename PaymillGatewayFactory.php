<?php
namespace Payum\Paymill;

use Payum\Paymill\Action\AuthorizeAction;
use Payum\Paymill\Action\CancelAction;
use Payum\Paymill\Action\ConvertPaymentAction;
use Payum\Paymill\Action\CaptureAction;
use Payum\Paymill\Action\NotifyAction;
use Payum\Paymill\Action\RefundAction;
use Payum\Paymill\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

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
            'payum.action.notify' => new NotifyAction(),
            'payum.action.status' => new StatusAction(),
            'payum.action.convert_payment' => new ConvertPaymentAction(),
        ]);

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
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

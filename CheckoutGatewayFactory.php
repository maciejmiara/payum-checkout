<?php

namespace MaciejMiara\Payum\Checkout;

use MaciejMiara\Payum\Checkout\Action\AuthorizeAction;
use MaciejMiara\Payum\Checkout\Action\CancelAction;
use MaciejMiara\Payum\Checkout\Action\ConvertPaymentAction;
use MaciejMiara\Payum\Checkout\Action\CaptureAction;
use MaciejMiara\Payum\Checkout\Action\NotifyAction;
use MaciejMiara\Payum\Checkout\Action\RefundAction;
use MaciejMiara\Payum\Checkout\Action\StatusAction;
use Payum\Core\Bridge\Spl\ArrayObject;
use Payum\Core\GatewayFactory;

class CheckoutGatewayFactory extends GatewayFactory
{
    /**
     * {@inheritDoc}
     */
    protected function populateConfig(ArrayObject $config)
    {
        $config->defaults([
            'payum.factory_name' => 'checkout',
            'payum.factory_title' => 'checkout',
            'payum.action.capture' => new CaptureAction(),
            'payum.action.authorize' => new AuthorizeAction(),
            'payum.action.refund' => new RefundAction(),
            'payum.action.cancel' => new CancelAction(),
            'payum.action.notify' => new NotifyAction(),
            'payum.action.status' => new StatusAction(),
            'payum.action.convert_payment' => new ConvertPaymentAction(),
        ]);

        if (false == $config['payum.api']) {
            $config['payum.default_options'] = array(
                'sandbox' => true,
            );
            $config->defaults($config['payum.default_options']);
            $config['payum.required_options'] = ['sandbox', 'merchant_secret'];

            $config['payum.api'] = function (ArrayObject $config) {
                $config->validateNotEmpty($config['payum.required_options']);

                return new Api((array) $config, $config['payum.http_client'], $config['httplug.message_factory']);
            };
        }
    }
}

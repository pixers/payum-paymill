# Paymill

[![Build Status](https://travis-ci.org/pixers/payum-paymill.png?branch=master)](https://travis-ci.org/pixers/payum-paymill)

The Payum extension for Paymill.

## Instalation

The preferred way to install the library is using [composer](http://getcomposer.org/).

Run:

```bash
php composer.phar require "pixers/payum-paymill"
```

## Symfony Integration (payum-bundle < 2.0)

### Add PaymillGatewayFactory to payum:

```php
<?php
// src/Acme/PaymentBundle/AcmePaymentBundle.php

namespace Acme\PaymentBundle;

use Payum\Paymill\Bridge\Symfony\PaymillGatewayFactory;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AcmePaymentBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('payum');
        $extension->addPaymentFactory(new PaymillGatewayFactory());
    }
}
```

### Configuration in config.yml:

```yaml
payum:
    gateways:
        ...
        paymill_gateway:
            paymill:
                sandbox: true
                api_private_key: LIVE_PRIVATE_KEY
                api_public_key: LIVE_PUBLIC_KEY
                test_private_key: TEST_PRIVATE_KEY
                test_public_key: TEST_PUBLIC_KEY
        ...
```

## Symfony Integration (payum-bundle >= 2.0)

### Add PaymillGatewayFactory to payum in services.yml:

```yaml
    paymill_gateway:
        class: Payum\Core\Bridge\Symfony\Builder\GatewayFactoryBuilder
        arguments: [Payum\Paymill\PaymillGatewayFactory]
        tags:
            - { name: payum.gateway_factory_builder, factory: paymill_gateway }
```

### Configuration in config.yml:

```yaml
payum:
    gateways:
        paymill_gateway:
            factory: paymill
            sandbox: true
            api_private_key: LIVE_PRIVATE_KEY
            api_public_key: LIVE_PUBLIC_KEY
            test_private_key: TEST_PRIVATE_KEY
            test_public_key: TEST_PUBLIC_KEY
```

## Resources

* [Payum Repository](https://github.com/Payum/Payum)
* [Paymill Documentation](https://developers.paymill.com/)

## License

Copyright 2016 PIXERS Ltd - www.pixersize.com

Licensed under the [BSD 3-Clause](LICENSE)
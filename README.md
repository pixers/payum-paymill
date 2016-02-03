# Paymill

[![Build Status](https://travis-ci.org/NetTeam/payum-paymill.png?branch=master)](https://travis-ci.org/NetTeam/payum-paymill)

The Payum extension for Paymill.

## Instalation

The preferred way to install the library is using [composer](http://getcomposer.org/).

Run:

```bash
php composer.phar require "netteam/payum-paymill"
```

## Symfony Integration

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

## Resources

* [Payum Documentation](http://payum.org/doc)
* [Paymill Documentation](https://developers.paymill.com/)

## License

Adyen plugin is released under the [BSD License](LICENSE).

<?php
namespace Payum\Paymill\Bridge\Symfony;

use Payum\Bundle\PayumBundle\DependencyInjection\Factory\Gateway\AbstractGatewayFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class PaymillGatewayFactory extends AbstractGatewayFactory
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'paymill';
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        parent::addConfiguration($builder);

        $builder
            ->children()
                ->scalarNode('api_private_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('api_public_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('test_private_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('test_public_key')->isRequired()->cannotBeEmpty()->end()
                ->booleanNode('sandbox')->defaultTrue()->end()
                ->end()
            ->end();
    }

    /**
     * {@inheritDoc}
     */
    protected function getPayumGatewayFactoryClass()
    {
        return 'Payum\Paymill\PaymillGatewayFactory';
    }

    /**
     * {@inheritDoc}
     */
    protected function getComposerPackage()
    {
        return 'NetTeam/payum-paymill';
    }
}

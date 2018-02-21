<?php

namespace Swoft\Sg;

use Swoft\App;
use Swoft\Exception\InvalidArgumentException;
use Swoft\Sg\Provider\ConsulProvider;
use Swoft\Sg\Provider\ProviderInterface;

/**
 * the selector of service provider
 */
class ProviderSelector implements SelectorInterface
{
    /**
     * consul
     */
    const TYPE_CONSUL = 'consul';

    /**
     * @var array
     */
    private $providers
        = [

        ];

    /**
     * Select a provider by Selector
     *
     * @param string $type
     * @return ProviderInterface
     * @throws \Swoft\Exception\InvalidArgumentException
     */
    public function select(string $type)
    {
        $providers = $this->mergeProviders();
        if (! isset($providers[$type])) {
            throw new InvalidArgumentException(sprintf('Provider %s does not exist', $type));
        }

        $providerBeanName = $providers[$type];

        return App::getBean($providerBeanName);
    }

    /**
     * merge default and config packers
     *
     * @return array
     */
    private function mergeProviders()
    {
        return array_merge($this->providers, $this->defaultProvivers());
    }

    /**
     * the balancers of default
     *
     * @return array
     */
    private function defaultProvivers()
    {
        return [
            self::TYPE_CONSUL => ConsulProvider::class,
        ];
    }
}

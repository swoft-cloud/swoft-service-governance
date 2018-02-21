<?php

namespace Swoft\Sg;

use Swoft\App;
use Swoft\Sg\Balancer\RandomBalancer;
use Swoft\Sg\Balancer\RoundRobinBalancer;
use Swoft\Sg\Balancer\BalancerInterface;

/**
 * the manager of balancer
 */
class BalancerSelector implements SelectorInterface
{
    /**
     * the name of random
     */
    const TYPE_RANDOM = 'random';

    /**
     * the name of roundRobin
     */
    const TYPE_ROUND_ROBIN = 'roundRobin';

    /**
     * @var array
     */
    private $balancers = [

    ];

    /**
     * get balancer
     *
     * @param string $type
     *
     * @return BalancerInterface
     */
    public function select(string $type)
    {
        $balancers = $this->mergeBalancers();
        if (!isset($balancers[$type])) {
        }

        $balancerBeanName = $balancers[$type];
        return App::getBean($balancerBeanName);
    }

    /**
     * merge default and config packers
     *
     * @return array
     */
    private function mergeBalancers()
    {
        return array_merge($this->balancers, $this->defaultBalancers());
    }

    /**
     * the balancers of default
     *
     * @return array
     */
    private function defaultBalancers()
    {
        return [
            self::TYPE_RANDOM => RandomBalancer::class,
            self::TYPE_ROUND_ROBIN => RoundRobinBalancer::class
        ];
    }
}

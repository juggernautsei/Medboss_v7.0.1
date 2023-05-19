<?php

namespace Juggernaut\Modules;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Bootstrap
{

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param mixed $kernel
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, mixed $kernel)
    {
    }

    public function subscribeToEvents()
    {
    }
}

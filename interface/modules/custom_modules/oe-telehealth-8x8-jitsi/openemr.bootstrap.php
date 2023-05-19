<?php

/*
 * @package OpenEMR
 *
 * @author Sherwin Gaddis <sherwingaddis@gmail.com>
 * Copyright (c) 2023.
 * @license "All rights reserved"
 */

namespace Juggernaut\Modules;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

require_once dirname(__DIR__) . '/oe-telehealth-8x8-jitsi/vendor/autoload.php';
/**
 * @global EventDispatcherInterface $eventDispatcher Injected by the OpenEMR module loader;
 */

$bootstrap = new Bootstrap($eventDispatcher, $GLOBALS['kernel']);
$bootstrap->subscribeToEvents();

<?php

require_once __DIR__ . '/vendor/autoload.php';

use Thruway\Peer\Router;
use Thruway\Transport\RatchetTransportProvider;
use LajosBencz\CliArgs;

$cliArgs = new CliArgs(array_slice($argv, 1));
$host = $cliArgs->getOption(['h', 'host'], '127.0.0.1');
$port = intval($cliArgs->getOption(['p', 'port'], 4000));

$router = new Router();

$router->registerModule(new RatchetTransportProvider($host, $port));
$router->addInternalClient(new NuxtWampBackend\Client());
$router->start();

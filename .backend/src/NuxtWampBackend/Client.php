<?php

namespace NuxtWampBackend;


use Thruway\ClientSession;
use Thruway\Peer\Client as ThruwayClient;

class Client extends ThruwayClient
{
  protected $_clientCount = 0;

  public function __construct()
  {
    parent::__construct("realm1");
  }

  public function onSessionStart($session, $transport)
  {
    $this->getLoop()->addPeriodicTimer(5, [$this, 'periodicTime']);

    $session->register('page', [$this, 'getPage']);
    $session->register('time', [$this, 'getTime']);
    $session->register('array', [$this, 'getArray']);
    $session->register('object', [$this, 'getObject']);
    $session->register('both', [$this, 'getBoth']);

    $session->subscribe('wamp.metaevent.session.on_join', function (...$meta) {
      $this->_clientCount++;
      echo '> joined ', $meta[3], PHP_EOL;
      echo '  clients: ', $this->_clientCount, PHP_EOL;
      //var_dump('> joined ', $meta[3]);
    });

    $session->subscribe('wamp.metaevent.session.on_leave', function (...$meta) {
      $this->_clientCount--;
      echo '< left ', $meta[3], PHP_EOL;
      echo '  clients: ', $this->_clientCount, PHP_EOL;
      //var_dump('< left ', $meta[3]);
    });
  }

  public function periodicTime(ClientSession $session)
  {
    $session->publish('timeArgs', [$this->getTime()]);
    $session->publish('timeKwArgs', [], ['time' => $this->getTime()]);
    $session->publish('timeBoth', [$this->getTime()], ['time' => $this->getTime()]);
  }

  public function getPage($args, $kwArgs)
  {
    static $pages = [
      'foo bar',
      'baz bax',
      'bop plop',
    ];
    $n = count($pages);
    return $pages[max(0, min($n - 1, $args[0]))];
  }

  public function getTime()
  {
    return (new \DateTime())->format(\DateTime::RFC3339_EXTENDED);
  }

  public function getArray()
  {
    return ['banana', 'radish'];
  }

  public function getObject()
  {
    return [
      'yellow' => 'banana',
      'red' => 'radish',
    ];
  }

  public function getBoth()
  {
    return [
      ['banana', 'radish'],
      [
        'yellow' => 'banana',
        'red' => 'radish',
      ],
    ];
  }

}

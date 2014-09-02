<?php
/**
 *
 */
require_once __DIR__ . "/../vendor/autoload.php";

use StateMachine\StateMachineInterface;
use StateMachine\StateMachine;
use StateMachine\StateEngine;
use StateMachine\StateEngineInterface;

/**
 * Example stateful object that uses delegation.  Of course, inheritance
 * could also be used, but I always prefer to keep loose coupling.
 */
class MyStatefulObject implements StateMachineInterface {
  protected $machine;

  function __construct(StateMachineInterface $delegate) {
    $this->machine = $delegate;
  }

  public function currentState() {
    return $this->machine->currentState();
  }

  public function setState($state) {
    return $this->machine->setState($state);
  }

  public function setStateEngine(StateEngineInterface $engine) {
    return $this->machine->setStateEngine($engine);
  }
}

function check_machine(StateMachineInterface $machine, $transitions) {
  echo "*****" . PHP_EOL;
  echo "Start checks" . PHP_EOL;

  foreach ($transitions as $state) {
    if ($machine->setState($state)) {
      echo "State transition to '" . $machine->currentState() . "'" . PHP_EOL;
    }
    else {
      echo "Could not transition to '" . $state . "'" . PHP_EOL;
    }
  }

  echo "Final object state is '" . $machine->currentState() . "'" . PHP_EOL;
  echo "*****" . PHP_EOL;
}

// Create a state engine using PHP, add some transitions, and inject into a
// state machine.
$engine = new StateEngine('initial');
$engine->addTransition('initial', 'intermediate');
$engine->addTransition('initial', 'intermediate_other');
$engine->addTransition('intermediate', 'intermediate_other');
$engine->addTransition('intermediate', 'final');
$engine->addTransition('intermediate_other', 'final');

// Run through a few state transitions and output the results.
$state_checks = array('final', 'intermediate', 'intermediate_other', 'initial', 'final');
$machine = new MyStatefulObject(new StateMachine($engine));
check_machine($machine, $state_checks);

// Create an engine from YAML configuration, then
// do some tests.
$loader = new \StateMachine\Loader\YamlLoader();
$engine_from_yaml = $loader->load(__DIR__ . "/example.yaml");
$machine_from_yaml = new StateMachine($engine_from_yaml);
check_machine($machine_from_yaml, $state_checks);

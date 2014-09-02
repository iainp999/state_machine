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

// Create a state engine, add some transitions, and inject into a
// state machine.
$engine = new StateEngine('initial');
$engine->addTransition('initial', 'intermediate');
$engine->addTransition('initial', 'intermediate_other');
$engine->addTransition('intermediate', 'intermediate_other');
$engine->addTransition('intermediate', 'final');
$engine->addTransition('intermediate_other', 'final');

$machine = new MyStatefulObject(new StateMachine($engine));

// Run through a few state transitions and output the results.
$state_checks = array('final', 'intermediate', 'intermediate_other', 'initial', 'final');

foreach ($state_checks as $state) {
  if ($machine->setState($state)) {
    echo "State transition to '" . $machine->currentState() . "'" . PHP_EOL;
  }
  else {
    echo "Could not transition to '" . $state . "'" . PHP_EOL;
  }
}

echo "Final object state is '" . $machine->currentState() . "'" . PHP_EOL;
<?php
namespace StateMachine;

use StateMachine\StateEngineInterface;

/**
 * Object containing state managed by a state machine.
 *
 * Can be used as a delegate or base class for objects that require
 * managed state transitions.
 *
 * @package StateMachine
 */
class StateMachine implements StateMachineInterface {
  /**
   * @type StateEngineInterface
   */
  protected $engine;

  /**
   * @type string
   */
  protected $state;

  /**
   * @param StateEngineInterface $engine
   */
  function __construct(StateEngineInterface $engine) {
    $this->setStateEngine($engine);
    $this->state = $engine->getInitialState();
  }

  /**
   * Get the current state.
   *
   * @return mixed|string
   */
  public function currentState() {
    return $this->state;
  }

  /**
   * Attempt to transition to the supplied state.
   *
   * @param $state
   * @return bool
   */
  public function setState($state) {
    if ($this->engine->checkTransition($this, $state)) {
      $this->state = $state;
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Set the state engine used by this machine.
   *
   * @param StateEngineInterface $engine
   */
  public function setStateEngine(StateEngineInterface $engine) {
    $this->engine = $engine;
  }
}

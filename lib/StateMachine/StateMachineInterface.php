<?php
namespace StateMachine;

/**
 * A state machine.
 *
 * @package StateMachine
 */
interface StateMachineInterface {
  /**
   * Get the current state.
   *
   * @return mixed
   */
  public function currentState();

  /**
   * Attempt to set the current state.
   *
   * @param $state
   * @return mixed
   */
  public function setState($state);

  /**
   * Set the state engine.
   *
   * @param StateEngineInterface $engine
   * @return mixed
   */
  public function setStateEngine(StateEngineInterface $engine);
}

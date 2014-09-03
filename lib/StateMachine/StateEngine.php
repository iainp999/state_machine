<?php

namespace StateMachine;

class StateEngine implements StateEngineInterface {

  protected $transitions = NULL;

  /**
   * @param $initial_state
   */
  function __construct($initial_state) {
    $this->initial_state = $initial_state;
  }


  /**
   * @param $state
   * @return mixed|void
   */
  public function addState($state) {
    if (empty($this->transitions[$state])) {
      $this->transitions[$state] = array();
    }
  }

  /**
   * @return array|mixed
   */
  public function getStates() {
    return array_keys($this->transitions);
  }

  /**
   * @param $from_state
   * @param $to_state
   * @return mixed
   */
  public function addTransition($from_state, $to_state) {
    $this->addState($from_state);
    $this->addState($to_state);

    if (!in_array($to_state, $this->transitions[$from_state])) {
      $this->transitions[$from_state][] = $to_state;
    }
  }

  /**
   * @param StateMachineInterface $entity
   * @param $target_state
   * @return mixed
   */
  public function checkTransition(StateMachineInterface $entity, $target_state) {
    if ($entity->currentState() == $target_state) {
      return TRUE;
    }

    if (!empty($this->transitions[$entity->currentState()])) {
      if (in_array($target_state, $this->transitions[$entity->currentState()])) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * @return mixed
   */
  public function getInitialState() {
    return $this->initial_state;
  }

  /**
   * @return mixed
   */
  public function getEndStates() {
    return array_filter($this->transitions, function($value) { return empty($value); });
  }

}

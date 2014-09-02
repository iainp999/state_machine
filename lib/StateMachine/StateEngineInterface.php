<?php
namespace StateMachine;

interface StateEngineInterface {

  /**
   * @param $state
   * @return mixed
   */
  public function addState($state);


  /**
   * @return mixed
   */
  public function getInitialState();

  /**
   * @return mixed
   */
  public function getEndStates();

  /**
   * @return mixed
   */
  public function getStates();

  /**
   * @param $from_state
   * @param $to_state
   * @return mixed
   */
  public function addTransition($from_state, $to_state);

  /**
   * @param StateMachineInterface $entity
   * @param $target_state
   * @return mixed
   */
  public function checkTransition(StateMachineInterface $entity, $target_state);

}

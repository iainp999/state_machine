<?php
namespace StateMachine\Loader;

use StateMachine\StateMachine;

interface LoaderInterface {

  /**
   * @param $source
   * @return StateMachine
   */
  public function load($source);

} 
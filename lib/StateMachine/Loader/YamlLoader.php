<?php
namespace StateMachine\Loader;

use StateMachine\StateEngine;
use StateMachine\StateMachine;
use Symfony\Component\Yaml\Parser;

class YamlLoader implements LoaderInterface {

  /**
   * @param $source
   * @return StateMachine
   */
  public function load($source) {
    if (!file_exists($source)) {
      throw new \Exception("File does not exist. '{$source}'");
    }

    $yaml = new Parser();
    return $this->buildEngine($yaml->parse(file_get_contents($source)));
  }

  protected function buildEngine(array $config) {
    if (!isset($config['engine'])) {
      throw new \Exception('No engine defined');
    }

    $config = $config['engine'];

    $initial_state = $config['initial'];
    $engine = new StateEngine($initial_state);

    // Add states
    foreach ($config['states'] as $state) {
      $engine->addState($state);
    }

    // Add transitions
    foreach ($config['transitions'] as $transition) {
      $engine->addTransition($transition['from'], $transition['to']);
    }

    return $engine;
  }
} 
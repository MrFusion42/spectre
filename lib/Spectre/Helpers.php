<?php

namespace Spectre;

class Helpers
{
  public static function execute(array $test, $node, $coverage, $description)
  {
    $err = array();

    $coverage && $coverage->start("$node->description $description");

    foreach ($test as $callback) {
      try {
        call_user_func_array($callback, static::inject($callback, $node));
      } catch (\Exception $e) {
        $err []= $e->getMessage();
      }
    }

    $coverage && $coverage->stop();

    return $err;
  }

  public static function inject(\Closure $block, $node)
  {
    $block = new \ReflectionFunction($block);
    $args = array();

    foreach ($block->getParameters() as $param) {
      $args []= $node->context->{$param->getName()};
    }

    return $args;
  }

  public static function scalar($args)
  {
    $out = array();

    foreach ($args as $one) {
      $type = gettype($one);
      $one = static::value($one);

      $out []= strlen($one) ? "($type) $one" : "($type)";
    }

    return $out;
  }

  public static function value($test)
  {
    if (is_array($test)) {
      $test = join(', ', static::scalar($test));
      $test = sizeof($test) > 1 ? "[$test]" : $test;
    } elseif (is_scalar($test)) {
      $test = false === $test ? 'false' : $test;
      $test = true === $test ? 'true' : $test;
      $test = null === $test ? 'null' : $test;
    } elseif ($test instanceof \Closure) {
      $test = '{closure}';
    } elseif (is_object($test)) {
      $test = get_class($test);
    }

    return $test;
  }
}

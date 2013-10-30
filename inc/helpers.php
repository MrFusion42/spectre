<?php

function expect($value)
{
  return new \Spectre\Expect($value);
}

function local($key, $value)
{
  return \Spectre\Base::instance()->local($key, $value);
}

function describe($desc, $cases)
{
  \Spectre\Base::instance()->describe($desc, $cases);
}

function it($desc, $test)
{
  \Spectre\Base::instance()->it($desc, $test);
}

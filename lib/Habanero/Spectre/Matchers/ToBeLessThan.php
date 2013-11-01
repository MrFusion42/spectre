<?php

namespace Habanero\Spectre\Matchers;

class ToBeLessThan extends Base
{
  public function execute($value)
  {
    if (is_array($this->expected) && is_array($value)) {
      return sizeof($this->expected) < sizeof($value);
    }

    if (is_numeric($this->expected) && is_numeric($value)) {
      return $this->expected < $value;
    }
  }
}
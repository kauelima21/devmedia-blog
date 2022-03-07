<?php

namespace Source\Controllers;

class Foo
{
  public function bar($args)
  {
    echo "Ola Mundo";
    if ($args) {
      var_dump($args);
    }
  }
}

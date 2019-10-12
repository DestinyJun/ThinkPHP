<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
  public function test()
  {
    $this->show('我是后台');
  }
}

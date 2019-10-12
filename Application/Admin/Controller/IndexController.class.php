<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
  public function index()
  {
//    $this->display();
    $this->display('./index.html');  // 指定模板文件
  }
}

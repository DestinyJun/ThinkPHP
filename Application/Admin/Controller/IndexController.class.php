<?php

namespace Admin\Controller;

use Think\Controller;

class IndexController extends Controller
{
  public function index()
  {
//    $this->display();
    $this->display('index');  // 指定模板文件
  }
  public function add()
  {
    $img = 'h哈哈';
    $data  = array(
      'name'=> 'wenjun',
      'version'=> '3.2',
    );
    $this->assign('img',$img); // 第一种
    $this->data = $data; // 第二种
    $this->display();
  }
}

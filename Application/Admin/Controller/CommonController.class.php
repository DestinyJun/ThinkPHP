<?php
namespace Admin\Controller;
use Think\Controller;

abstract class CommonController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    // 判断用户是否登陆
    if (!session('user')) {
      $this->error('您没有登陆',U('Login/login'));
    }
  }
}

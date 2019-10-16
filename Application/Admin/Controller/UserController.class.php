<?php
namespace Admin\Controller;
use Think\Controller;

final class userController extends Controller
{
  public function index()
  {
    $model = D('user');
    $res = $model->add(array(
      'username'=>'xq',
      'password'=>'e10adc3949ba59abbe56e057f20f883e',
      'name'=>'谢青',
      'tel'=>'13888888888',
    ));
    dump($res);
  }
}

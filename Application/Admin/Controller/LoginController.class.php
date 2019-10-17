<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Verify;

final class LoginController extends Controller
{
  public function login(){
    $this->display();
  }
  // 生成验证码
  public function captcha(){
    $config = array(
      'length'=> 4
    );
    $codeObj = new Verify($config);
    $codeObj ->entry();
  }
  // 登陆验证
  public function checkLogin(){
    $model = D('Login');
    $username = I('post.username');
    $password = I('post.password');
    $code     = I('post.code');
    $codeObj = new Verify(array('length'=>4));
    if (!$codeObj->check($code)) {
      // TP在控制器基类中给我们提供了一个返回ajax请求数据的方法
      $data = array(
        'status'=>1001,
        'msg'=>'验证码错误',
      );
      $this->ajaxReturn($data);
    }

    /*echo json_encode(array(
      'username'=>$username,
      'password'=>$password,
      'code'=>$code,
    ));*/
  }
}

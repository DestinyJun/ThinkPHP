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
  public function add()
  {
    if (IS_GET){
      $this->display();
    } else {
      $model = D('user');
      // 定义具体自动完成规则
      $auto=array(
        array('addate','time',1,'function')
      );

      // create可以根据数据表字段过滤数据
      // create默认只能处理post请求提交的数据
      // create($_GET)或者create(I('get.')) 开启create处理get方式请求的数据
      // I函数用于接受表单等提交的参数
      // 添加参数校验后，一旦参数校验不通过，$model->create()就会返回false
      // 动态方式创建自动处理规则
      $data = $model->auto($auto)->create();
      if ($data) {
        // 判断参数是否校验通过后的做什么
        // 获取模型里面的错误信息
        dump($model->getError());
      }
    }


  }
}

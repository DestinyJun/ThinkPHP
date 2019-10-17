<?php
namespace Admin\Controller;
use Think\Page;
use Think\Verify;

final class userController extends CommonController
{
  public function index()
  {
    if (IS_GET){
      $model = D('user');
      // TP的分页类
      $count  = $model->count(); // 拿到数据总条数
      $pagesize = 1; // 定义每页显示多少条
      $page = new Page($count,$pagesize); // 实例化TP的分页类
      $show = $page->show(); // 拿到分页html信息
      $this->assign('page',$show); // 把分页信息赋值给模板
      // 根据分页信息显示数据
      $p = I('get.p'); // 接收当前页码
      // $model->page()的page()方法帮我们做好了分页计算，只需要传入当前页及每页显示多少即可。
      $data = $model->page($p,$pagesize)->select(); // 根据当前页查询数据，
      $this->assign('data',$data);
      $this->display();
    }
  }
  // TP验证码类的使用
  public function captcha()
  {
    // 初始化验证码配置
    $codeConfig = array(
      'length' => 4,
      'codeSet' => '0123456789',
    );
    $code = new Verify($codeConfig); // 实例化验证码类
    $code->entry(); // 渲染验证码图片
  }
  // 验证码校验
  public function codeCheck()
  {
    // TP验证码类的使用
    // 初始化验证码配置
    $codeConfig = array(
      'length' => 4,
      'codeSet' => '0123456789',
    );
    $codeObj = new Verify($codeConfig); // 实例化验证码类
    $code = I('get.code'); // 接收验证码
    // 校验验证码
    $res = $codeObj->check($code);
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
  public function test1()
  {
    // 模型事物处理功能
    $model = D('user');
    // 开启事物处理
    $model->startTrans();
    $res1 = $model->where('id=1')->save(array(
      'role'=> '1',
      'tel'=> '18888888888',
    ));
    $res2 = $model->where('id=4')->save(array(
      'heihei'=> '1', // heihei字段不存在
    ));
    if (!$res1 && !$res2){
      $model->commit(); // 提交事物，确认修改
    } else {
      $model->rollback(); // 否则就回滚事物，不修改
    }
  }
  public function test2()
  {
    $model = D('user');
    // field作用是指定具体需要的字段信息，其参数格式跟原生sql一模一样
    $model->field('id,username')->select();
    // alias的作用是指定具体的表别名
    $model->alias('a')->field('id,username')->where('a.id>2')->select();
    // order的作用是指定具体的排序
    $model->alias('a')->order('id desc')->field('id,username')->where('a.id>2')->select();
    // limit的作用是限制具体的条数，其有两种使用方式（跟原生SQL语句一样）
    // ①直接设置具体数字，指定显示多少条数据
    // ②直接设置两个字符‘2，3’这种格式，实现分页效果
    $model->alias('a')->order('id desc')->limit(3)->field('id,username')->where('a.id>2')->select(); // 限制三条
    $model->alias('a')->order('id desc')->limit('2,3')->field('id,username')->where('a.id>2')->select(); // 分页
  }
  public function test3()
  {
    // 实现TP中的连表查询
    $model = D('user');
    // join方法能够实现连表查询功能
    // join指定具体的连表查询条件（首先指定具体的连接方式【左连右连还是内连】、指定具体连接哪一张数据表、
    // 指定具体的连接字段，跟原生SQL的写法一致,如果还需连接更多的表，写生更多的join函数即可
    $data =  M('article')->alias('a')->field('a.*,b.nikename')->join('left join user b on a.user_id=b.id')->limit(3)->select();

    // 使用原生的sql语句
    $model->query('select * from user');
    $model->execute('insert into user values ()');
    dump($data);
  }
  public function sets()
  {
    session('name','文君'); // TP提供的全局函数设置session
    $_SESSION['age'] = '18'; // 原生方式设置session
  }
  public function gets()
  {
    dump(session()); // 读取全部session数据
    dump(session('name')); // 读取指定session数据
  }
  public function dels()
  {
    session('age',null); // 删除指定session数据
  }
  // TP中cookie操作
  public function setc()
  {
    // 不指定有效时间，默认关闭浏览器cookie就会失效
    cookie('name','文君','expire = 3600'); // 设置cookie及有效时间
  }
  public function getc()
  {
    dump(cookie('name')); // 读取指定session数据
  }
  public function delc()
  {
    cookie('name',null); // 删除指定session数据
  }
}

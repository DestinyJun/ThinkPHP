<?php
namespace Admin\Model;
use Think\Model;

final class userModel extends Model
{
  // 通过属性指定具体的主键字段信息，其是一个默认值，默认值是id，可以不写，如果数据表的主键字段不是id，则需要写
  protected $pk = 'id';
  // 实现TP数据表字段定义，将数据表的每个字段写入到数组中，提高处理数据的速度
  // 对应数据表的所有字段都要写，否在在进行数据交互时，对应缺少的字段不能正常进行数据交互
  protected $fields = array(
    'id',
    'username',
    'nikename',
    '.......'
  );
  // $fields及$pk都是TP基类数据模型定义好的
  // $model->getOk() 获取对应的主键名称

  // 字段映射的属性，其数据类型是一个数组，下标表示字段的假命，对应的值就是真名
  protected $_map = array(
    'name' => 'username',
    'nike' => 'nikename',
    '假名...' => '真名...',
  );

  // 实现自动验证规则,这里的字段名称需要与数据表字段一致，不能使用假名
  protected $_validate = array(
    array('username','checkName','用户名只能输数字或字母',1,'callback',3),
    array('nikename','check_nike','昵称只能是汉字',1,'function',3),
    array('tel','mobile','电话号码为11为数字',1,'regex',3),
  );
  // 校验username的成员方法
  public function checkName($username)
  {
    $regex = '/[0-9a-zA-Z]/g';
    if (preg_match($regex,$username)){
      return true;
    } else {
      return false;
    }
  }
  // 校验nikename的公共方法check_nike()需要卸载TP指定的目录下：Application/Common/Common/function.php文件里面

  // 重写钩子函数
  public function _before_insert(&$data, $options)
  {
    dump($data);
  }

  public function _after_insert($data, $options)
  {
    dump($data);
  }
}

<?php
namespace Admin\Controller;
use Think\Controller;

final class UploadsController extends Controller
{
  public function index()
  {
    if (IS_GET) {
      $this->display();
    } else {
      $model = D('Uploads');
      $data = $model->create();
      if(!$data) {
        $this->error($model->getError());
      }
      $res = $model->add($data);
      if (!$res) {
        $this->error($model->getError());
      }
//      $this->success('写入数据成功');
    }
  }
}

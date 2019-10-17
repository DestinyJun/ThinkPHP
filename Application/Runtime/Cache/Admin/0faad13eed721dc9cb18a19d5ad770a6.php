<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>用户管理</title>
  <style>
    table, table tr th, table tr td {
      border: 1px solid #0094ff;
    }
    table {
      width: 200px;
      min-height: 25px;
      line-height: 25px;
      text-align: center;
      border-collapse: collapse;
    }
  </style>
</head>
<body>
<h1>用户管理</h1>
<div class="table">
  <table>
    <thead>
    <tr>
      <th>id</th>
      <th>名字</th>
      <th>头像</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
      <td><?php echo ($vo["id"]); ?></td>
      <td><?php echo ($vo["name"]); ?></td>
      <td><img src="/<?php echo ($vo["avatar"]); ?>" alt="" width="50px" height="50px"></td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
</div>
<div class="page">
  <?php echo ($page); ?>
</div>
<div class="code">
  <img src="<?php echo U('captcha','timer=4');?>" alt="验证码">
</div>
</body>
</html>
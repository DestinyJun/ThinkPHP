<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>登陆</title>
  <script src="https://s0.pstatp.com/cdn/expire-1-M/jquery/3.4.0/jquery.min.js" type="application/javascript"></script>
</head>
<body>
<div class="login">
  <div class="username">
    <label for="username">用户名</label>
    <input type="text" id="username" name="username">
  </div>
  <div class="password">
    <label for="password">密码</label>
    <input type="text" id="password" name="password">
  </div>
  <div class="code">
    <label for="code">验证码</label>
    <input type="text" id="code" name="code">
    <img src="<?php echo U('captcha');?>" alt="">
  </div>
  <div class="button">
    <button type="button" id="button">登陆</button>
  </div>
</div>
</body>
<script>
$('#button').on('click',function () {
  const username = $('#username').val();
  const password = $('#password').val();
  const code = $('#code').val();
  console.log(code);
  $.ajax({
    url: "<?php echo U('checkLogin');?>",
    type: "POST",
    dataType: "JSON",
    data: {
      username:username,
      password:password,
      code:code
    },
    success:function (data) {
      console.log(data);
    }
  })
})
</script>
</html>
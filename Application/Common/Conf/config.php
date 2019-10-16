<?php
return array(
  //'配置项'=>'配置值'
  'TMPL_PARSE_STRING' => array(
    '__PUBLIC_ADMIN__' => '/Public/Admin', // 后台静态资源目录
    '__PUBLIC_HOME__' => '/Public/Home',    // 前台静态资源目录
  ),
  'DB_TYPE' => 'mysql',     // 数据库类型
  'DB_HOST' => '127.0.0.1', // 服务器地址
  'DB_NAME' => 'blog',          // 数据库名
  'DB_USER' => 'root',      // 用户名
  'DB_PWD' => 'root',          // 密码
  'DB_PORT' => '3306',        // 端口
  'DB_PREFIX' => '',    // 数据库表前缀
  'SHOW_PAGE_TRACE' => true,    // 开启TP的开发者工具
);

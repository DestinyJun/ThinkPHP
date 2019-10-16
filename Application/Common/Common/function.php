<?php
// 定义项目使用的公共函数，此文件下的函数会自动载入到项目中，并且所有函数可以在项目的任何模块下使用
function check_nike($nikename)
{
  $regex = '/[^\u4e00-\u9fa5]/g'; // 匹配不是汉字
  if (preg_match($regex,$nikename)){
    return true;
  } else {
    return false;
  }
}

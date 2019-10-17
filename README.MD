# ThinkPHP学习（2019-10-11 —— 2019-10-17）
* 注意：
  > * 在后端代码中的路径，跟浏览器解析的路径是有很大区别的
  > * 浏览器中的路径是服务器路径，一般都是/分割目录,是相对于服务器根目录来说的，或者相对当前自身来说的
  > * 而后端代码中的路径，既可以使用操作系统的物理路径，也可以使用服务器的相对路径
* TP中常用的内置常量：
  > * IS_GET：判断是否是get请求
  > * IS_POST：判断是否是post请求
  > * IS_AJAX：判断是否是ajax请求
  > * ajaxReturn：TP在控制器基类中给我们提供了一个返回ajax请求数据的方法
* TP中的一些调试配置的开启：
  > *   'SHOW_PAGE_TRACE' => true,    // 开启TP的开发者工具
### 1、版本选择
* （1）目前在TP的官网有两个大版本5.x及3.x版本
* （2）5.x版本主要针对写接口使用的，如给Android以及IOS及前后端分离设计接口使用
* （3）3.x版本主要针对写web项目使用，如官网、电商网站等
* （4）这两个版本还对应完整版和核心版本，一般在项目中使用完整版本，因为功能更多
### 2、相关目录介绍
```
TP框架目录介绍        
+-- Application       --默认的应用代码存储目录
|   +-- Common          --所有模块的公共模块（前后台应用的公共模块，实际项目中设置为不能访问）
|   +-- Home            --前台模块
|   |   +-- Common        --存储当前模块下的函数
|   |   +-- Conf          --当前模块下的配置信息
|   |   +-- Controller    --当前模块下的控制器
|   |   +-- Model         --当前模块下的模型
|   |   +-- View          --当前模块下的视图
|   |   +-- index.html    --当前模块下的安全文件，防止用户直接访问该目录
|   +-- Runtime         --具体项目运行中的临时存储的地址（实际项目中设置为不能访问）
+-- Public            --默认的存储静态资源的目录
+-- ThinkPHP          --TP框架的源代码
|   +-- Common          --TP公共函数存放目录
|   +-- Conf            --TP默认配置项
|   +-- Lang            --TP的语言包
|   +-- Lang            --TP的语言包
|   +-- Library         --TP的核心源码库
|   |   +-- Behavior      --TP的行为
|   |   +-- Org           --TP的第三方扩展库
|   |   +-- Think         --TP的核心类文件
|   |   +-- Vendor         --TP某些核心类文件
|   +-- Model           --TP的模式支持
|   +-- Tpl             --TP默认的系统模板
|   +-- ThinkPHP.php    --TP框架的入口，通过引入该文件，即可载入TP框架
+-- .htaccess         --Apache的重写规则文件
+-- composer.json     --PHP包管理工具的配置文件
+-- index.php         --代表整个项目的入口文件，具体调度TP的源代码
```
### 3、定义应用的相关规则
* （1）使用TP框架，其应用的存储常量名必须为：APP_PATH
* （2）控制器的命名规则：控制器名称（首字母大写）+controller+.class.php
* （3）控制器必须放在各个目录的controller目录下
### 4、创建控制器的流程
* （1）设置命名空间
* （2）引入TP的控制器基类
* （3）创建自己的控制器类
* （3）创建自己的方法
### 5、TP框架中四种URL访问模式介绍
* （1）TP的默认方式访问格式(普通模式），此模式没有任何限制条件，在任何情况下都能使用
    > * 通俗的访问地址是：`http://www.tp.com/Index.php?m=Admin&c=Index&a=test`
* （2）pathinfo模式（注意：此模式需要服务器软件支持，目前不支持的只有nginx）：此模式在访问的地址格式上看起来比较像访问某一个目录下的文件，此模式比较符合搜索引擎优化
    > * 通俗的访问地址是：`http://www.tp.com/Index.php/Admin/Index/test/name/value`
    > * Admin：指定具体的模块名称
    > * Index：指定具体的控制器名称
    > * index：指定具体的控制器里面的方法名称
    > * name：具体参数名称
    > * value：具体参数值
* （3）重写模式：重写模式在pathinfo的基础之上增加一个重写的规则（需要web服务器提供具体的重写规则），对于重写模式，一般使用在隐藏项目的入口文件（主要用来隐藏项目的入口文件，提高安全）
    > * 注意：对于重写模式，具体的访问格式不固定，受具体的重写规则文件的影响
    > * 通俗的访问地址是：`http://www.tp.com/Admin/Index/test/name/value`
    > * 注意：如果使用phpstudy搭建服务器环境访问时出现No input file specified，有以下两个方式解决：
    >> * A：如果你的PHP版本是带NTS结尾的，那么请把.htaccess文件中的^(.*)$ index.php后面加个?号（^(.*)$ index.php?），变成伪静态规则即可
    >> * B：把PHP版本改成无NTS结尾的
* （4）兼容模式：为了确保想要使用pathinfo模式，但是web服务器又不支持此模式时使用，对于兼容模式同样时通过给入口文件传参数实现，默认情况下兼容模式传递s参数来指定模块、控制器、方法名称
    > * 通俗的访问地址是：`http://www.tp.com/index.php?s=/Admin/Index/test`
### 6、TP的调试模式
* （1）TP的调试模式其实就是控制了TP关于配置信以及函数的缓存功能
* （2）如果开启调试模式，每次访问项目，TP都会去加载最新的配置以及函数信息
* （3）如果关闭了调试模式，当第一次访问TP会将配置以及函数信息保存到一个文件中（common-runtime.php文件中),后续访问时就会每次直接读取该文件中保存的各种信息而不去加载最新的配置信息
* （4）建议在开发阶段开启调试模式（在入口文件index.php中的`define('APP_DEBUG',false)`此处进行配置
* （5）开启调试模式后能够使用最新的配置信息，且当代码出错时在调试模式下能够看到具体的错误信息
* （6）如果项目需要上线，建议一定要关闭调试模式，减少日志文件的生成，且代码出错时只会提示并不提示具体的错误位置，保证安全
* （7）如果爆出的错误是TP框架的文件，那么错误原因可能是环境因数导致的，一般框架是不可能出现大错误的
* （8）如果爆出的错误是自己定义的代码文件，那么一定是自己的代码写错了
### 7、TP中配置文件的位置（有三处）
* （1）TP默认的惯例配置文件：ThinkPHP\Conf\convention.php
* （2）公共模块的配置文件：\Application\Common\Conf\config.php
* （3）模块配置文件：\Application\Home\Conf\config.php
* （4）配置文件的优先级：模块配置>公共模块的配置文件>TP默认的惯例配置文件
* （5）C函数是TP提供的一个获取配置信息（传递一个参数）、临时设置配置信息（传递两个参数）的重要函数
* （6）实际开发中不要直接修改TP默认配置项中的配置，如果要修改，可用覆盖的方式修改（即是修改公共模块配置及应用配置模块即可）
### 8、TP的URL生成函数U的使用
* （1）默认生成的是pathinfo模式的URL地址
* （2）如果未指定模块，其会自动加上默认启动的应用模块及控制器
* （3）修改配置文件的'URL_MODEL'的值，可修改生成的URL访问模式,可选参数0、1、2、3,代表以下四种模式：
   > * 0 (普通模式);
   > * 1 (PATHINFO 模式);
   > * 2 (REWRITE  模式) ——重写模式; 
   > * 3 (兼容模式)  默认为PATHINFO 模式
### 9、页面跳转提示
* 使用TP的控制器基类里面的$this->success及$this->error函数即可
* 其默认提示的html模板是可用修改的，在ThinkPHP的Tpl文件夹下面的dispatch_jump.tpl文件修改即可
### 10、页面重定向
* 使用TP的控制器基类里面的$this->redirect函数即可
### 11、空操作
* （1）当用户访问某一个控制器下的不存在的方法，TP会自动的将执行当前控制器下对应的_empty方法，此机制就是空操作
* （2）只需要在控制器中重写empty()方法，如果找不到相应的控制器函数，其就会自动调用
### 12、空控制器
* （1）当用户访问一个不存在的控制器时，TP会自动执行空控制器下的对用方法，此机制就是空控制器
* （2）使用：只需要在放置控制器的文件夹中创建一个EmptyController.class控制器，再在空控制器中创建一个空操作函数即可提高用户体验
* （3）如果空控制器中不存在要访问的方法，就是执行空操作函数
### 13、display的使用
* （1）获取要输出的内容,然后直接输出
* （2）参数说明：
    > * $templateFile
    > * $charset
    > * $contentType
    > * $content
    > * $prefix
* （3）display方法如果不传递任何参数，TP会自动定位到当前控制下的对应的同名方法的模板中
* （4）指定当前控制器下模板时，只需要传递模板的名称即可，不要后缀名：$this->display('index'')
* （5）指定其他控制器下(TestController)的模板时，参数为：$this->display('Test:test'); 
* （5）指定其他模块下的(Admin/Home模块)的模板时，参数为：$this->display('Admin@Index:add');
* （5）使用完整的模板名称（实际开发中不建议使用）：$this->display('./index.html'); 
### 13、fetch的使用
* （1）获取要输出的内容然,需要手动输出（实际中用的很少）
* （2）具体使用：`$str = $this->fetch('./index.html'); echo $str;(还可以：$this->show($str)`
### 14、模板替换
* （1）引入css样式：/Public/Admin/css/*.css
* （2）引入js文件：/Public/Admin/js/*.js
* （3）引入image文件：/Public/Admin/images/*.png
* （4）关于资源文件路径的修改，可使用TP的模板替换技术，减少修改目录的麻烦
* （5）所谓模板替换，就是在渲染一个模板文件值卡吗，TP会自动将模板文件中的特殊字符进行替换，替换称为具体所设置的值
* （6）TP内置的模板替换规则：
    > * `__ROOT__`：会替换成当前网站的地址（不含域名）
    > * `__APP__`：会替换成当前应用URL的地址（不含域名）
    > * `__MODULE__`：会替换成当前模块URL的地址（不含域名）
    > * `__CONTROLLER__`：会替换成当前控制器URL的地址（不含域名）,也可以写成`__URL__`
    > * `__ACTION__`：会替换成当前操作函数的URL的地址（不含域名）
    > * `__SELF__`：会替换成当前页面URL的地址
    > * `__PUBLIC__`：会替换成当前网站的公共目录，通常是/Public
* （8）添加自定义规则，可在配置项的'TMPL_PARSE_STRING'=>array()中配置，案例如下：
    > * 配置public/Admin目录：`'__PUBLIC_ADMIN__'=>'/public/Admin'`
### 15、给模板赋值
* （1）`$this->assign('img',$img);`
* （2）`$this->data = $data; `（很少用）
* （3）模板解析：`<span>{$img}</span>`
### 16、系统变量
* （1）系统变量就是TP内置的一个变量，对于系统变量可用直接在模板中使用，不需要进行任何赋值操作！
* （2）对于TP的系统变量可以输出的内容包括TP内置的配置项信息、TP或者PHP内置的常量、PHP的超全局数组，对于在模板中使用系统变量是都是{$Think}开头
### 17、TP的模板函数
* （1）时间格式化模板函数{$time|date:'Y-m-d H:i:s',###}
* （2）时间格式化特殊学写法{:(接上PHP原生代码)}：案例：{:date('Y-m-d H:i:s',$time)}
* （3）生成连接地址的特殊写法：{:U('index','id=4')} （说明：“：”后面跟上TP的原生函数或者PHP的原生函数
### 18、模板运算符
* （1）在模板中执行简单的加减乘除运算：`{$a +\-\*\/ $b}`
* （2）数组元素的运算：`{$data['a'] +\-\*\/ $data['b']}`,这里注意。数组元素的运算在TP模板引擎中不支持点语法，要用原生php的写法
### 19、TP中模板引擎标签（比如if，foreach)
* （1）TP的模板引擎标签的解析符号跟普通标签的解析符号{}是不一样的，其默认是<>，自己可以在配置文件中修改
* （2）foreach循环标签，案例写法：  
``` php
// name：指定具体需要循环的数据
// item：指定每次循环的临时变量
// key： 指定每次循环的下标
<foreach name="list" item="vo" key="k">
    {$k}|{$vo.id}:{$vo.name}
</foreach>
```
* （2）if判断标签，案例写法： 
``` php
// condition 指定具体判断条件，eq、OR、gt为运算符为各种逻辑运算符
// OR表示或者 AND表示并且
// eq/equal => 等于
//neq/notequal => 不等于
//neq/notequal => 不等于 
//gt => 大于 
//egt => 大于等于
//lt => 小于
//elt => 小于等于
//heq => 恒等于
//nheq => 不恒等于
<if condition="($name eq 1) OR ($name gt 100)"> [需要显示的html节点1]
<else if condition="$name eq 2"/> [需要显示的html节点2]
<else />[需要显示的html节点3]
</if>
```
* （3）比较标签，案例：
``` php
// 比较标签：eq、neq、gt、egt、lt、elt、heq、nheq
// name：消炎药判断到的变量名称
// value：需要比较的值
<比较标签 name="变量" value="值">
    需要显示的内容
</比较标签>
```
* （4）volist循环标签，案例：
``` php
// name：指定需要循环的变量名称
// id：指定每次循环的临时变量名称
// mod：其值是一个number类型，设置的值跟0在循环中交替出现，实现隔行变色（默认时0，1交替出现）
// empty：当循环的变量为空时显示的值
// offset：指定循环偏移量（指定具体从哪一个元素开始循环）
// length：指定具体的循环次数
// key：指定具体循环的下标变量名称，具体下标对应的值（1，2，3......)
// $key：可用拿到具体下标
<volist name="lisy" id="vo" mod="2" empty="没有内容" offset="2" legth="2" key="keys"></volist>
```
### 20、TP中实现模板共用
* （1）file地址拼接跪着：模块/控制器/操作
* （1）第一种写法：<include file="Public/header" /> （默认就是当前目录下的模板文件，模板文件中只需要放置公共部分的html代码即可）
* （1）第二种写法：<include file="Public：header" /> （默认就是当前目录下的模板文件，模板文件中只需要放置公共部分的html代码即可）
* （3）第三种写法：直接包含模板文件：<include file="./Application/Home/View/Public/header.html" /> （把路径写全即可）
### 21、TP中的视图创建规则（建议，不是一定）
* （1）TP建议将模块的具体视图文件放到对应模块的view目录中
* （2）TP建议根据具体的控制器在视图的View目录下创建同名的目录
* （3）TP建议将具体的视图模板文件名称跟具体的方法名称保持一致
* （4）TP建议将各个控制器具体的视图模板文件放置到View目录下的跟控制器同名的目录下
### 22、TP中的模板继承
* （1）需要继承的基础模板：
``` html
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>模板继承-父模板</title>
  <link rel="stylesheet" href="">
</head>
<body>
<block name="header"><h3>我是头部</h3></block>
<block name="content"><h3>我是内容</h3></block>
<block name="footer"><h3>我是底部</h3></block>
</body>
<block name="js"><h3>我是js</h3></block>
</html>
```
* （2）子模版继承并按需实现（实现的位置会替换基础模板中的html，不实现的位置将显示基础模板中的html，由此实现代码复用及前端组件化）：
``` html
<extend name="Public/base" />
<block name="content">
  <h1>商品添加</h1>
</block>
```
### 23、TP的数据库配置
* 把TP中的数据库配置在项目根目录下的Common下的配置文件中进行覆盖：
``` php
  'DB_TYPE' => 'mysql',     // 数据库类型
  'DB_HOST' => '127.0.0.1', // 服务器地址
  'DB_NAME' => 'blog',          // 数据库名
  'DB_USER' => 'root',      // 用户名
  'DB_PWD' => 'root',          // 密码
  'DB_PORT' => '3306',        // 端口
  'DB_PREFIX' => '',    // 数据库表前缀
```
### 23、TP的数据模型创建规则
* （1）模型存储地址规则：/应以名/模块名/Model目录中
* （2）模型文件命名规则：模块名+Model+.class.php,首字母大写，驼峰命名法，一般跟数据表的名称一致（跟模块名称一致）
* （3）代码创建规则：命名空间+TP模型基类+自己的代码
### 24、TP实例化模型对象的方式
* （1）new关键字创建对象(TP的泪痣函数dump函数可以打印数据对象，等价于：echo pre + var_dump)
* （2）使用TP内置M行数实力化对象：
``` php
    // 默认右三个参数
    // 第一个参数：指定具体的某一个数据表（默认没有前缀）
    // 第二个参数：指定具体的表前缀
    // 第三个参数：指定具体的数据库的连接信息
    // M函数是实例化TP的模型基类，不能实例化自定义模型类
    $model = M() // 此方式不传递参数，一般是在需要直接使用原生SQL语句时使用（用的比较少）
    $model = M('article') // 此方式指定了具体操作的数据表，可使用TP模型基类的具体方法对数据进行操作
```
* （3）使用TP内置D行数实力化对象：
``` php
    // D函数可以实例化自己定义的对象，也能实例TP的模型基类，其使用时必须传递参数
    // 关于D函数使用传递参数时，需指定自定义模型的名称,其模型名称需跟表名一致（表名不区分大小写）
    // 关于使用D函数实例化模型对象，是实例自定义的模型类的对象
    // D函数实例化对象支持跨模块使用,只需要传递跨模块的参数：模块名称（Home或者Admin）/模型类名称（也能自动解决命名空间）
    // 当实例化一个不存在的自定义模型类时，D函数会使用TP的模型基类进行实例化操作
    // 如果传递的参数的既不是自定义模型类的名称，也不是数据库中的某一张表的名称，则就会报错
    $model = D('Goods') // 传递自定义模型类名称
    dump($model);
```
* （4）M函数跟D函数的区别：M永远实例化TP的模型的基类，D会优先实例化自定义模型类，如果自定义模型类不存在，就会实例化TP的模型基类
* （5）实际开发中建议使用D函数实例化自定义的数据模型类对象，因为只使用TP内置的模型基类，功能不方便扩展，可能达不到项目需求
### 25、TP模型基类的CURD操作
* TP基类数据模型已提供一下几种对数据操作的等几种方法：
* （1）add：新增一条数据，成功后返回该条数据的数据库id，传入的参数是一维数组，案例：  
``` php
    $model = D('user');
    $res = $model->add(
      array(
        'username'=>'xq',
        'password'=>'e10adc3949ba59abbe56e057f20f883e',
        'name'=>'谢青',
        'tel'=>'13888888888',
      )
    );
  ```
* （2）addAll：新增多条数据，成功后返回插入的第一条数据的数据库id，传入的参数是二维数组（下标必须是0，1，2...）案例：  
``` php
    $model = D('user');
    $res = $model->add(
      array(
        array(
        'username'=>'xq',
        'password'=>'e10adc3949ba59abbe56e057f20f883e',
        'name'=>'谢青',
        'tel'=>'13888888888',
        ),
        array(
          'username'=>'xq',
          'password'=>'e10adc3949ba59abbe56e057f20f883e',
          'name'=>'谢青',
          'tel'=>'13888888888',
          )
      )
    );
  ```
* （3）save：修改一条数据，成功后返回受影响的函数，失败返回false，传入的参数是需要修改的字段的及需要修改数据的主键id的一维数组，案例：  
``` php
    $model = D('user');
    $res = $model->save(
      array(
        'id'=>'6'，
        'username'=>'xq',
        'password'=>'e10adc3949ba59abbe56e057f20f883e',
        'name'=>'谢青',
      )
    );
```
* （4）setFiled：修改个别字段，参数有两种形式，一是一维数组，下标为具体需要修改的字段，二是key，value的形式，案例：  
``` php
    $model = D('user');
    $res = $model->where('id=6')->setFiled(array(
       'nikename'=>'小胖子',
       'username'=>'xpz',
    ))
    $res = $model->where('id=6')->setFiled('nikename','小胖子')
```
* （5）setInc：指定将某一个字段的值进行增加操作，第一个参数指定需要增加的字段名，第二个自定增加多少，第二个参数不填默认+1案例：  
``` php
    $model = D('user');
    $res = $model->where('id=6')->setFiled('setInc',5)
```
* （6）setDec：指定将某一个字段的值进行减少操作（使用方式跟setInc一致）   
* （7）find：获取一条数据，返回的数及数据格式是一维数组
``` php
    $model = D('user');
    $res = $model->where('id=6')->find()
```
* （8）select：获取多条数据，返回的数及数据格式是二维数组
``` php
    $model = D('user');
    $res = $model->where('id>6')->select()
```
* （9）delete：数据删除，必须配合where使用，否则无效，因为直接删除存在危险,返回结果为受影响的行数
``` php
    $model = D('user');
    $res = $model->where('id>6')->delete()
```  
* （10）连贯操作where条件筛选操作数据（其可以配合增删改查操作），只要条件匹配的数据，都会被操作，其参数可以是数组格式，可以是原生sql的where子语句，案例：  
``` php
    $res = $model->$where("id=6")->save()
```
* （11）TP中获取数据库操作的SQL语句：$model->getLastSql()
### 26、TP数据表字段缓存
* （1）字段缓存的的概念：将具体的字段信息保存到某一个具体的文件中，但下次实例化模型类对象时会直接读取文件信息，不再去范围内西具体的数据表结构，减少MySQL压力
* （2）开启字段缓存：关闭调试模式，即可开启字段缓存
* （3）在调试模式下，TP每次都会分析具体的字段结构信息（不论是否存在字段换成文件）
### 27、TP数据表字段定义
* （1）概念：在自定义模型中将具体的字段信息保存到某一个具体的属性中（此属性名称是固定的），本质也即是将具体的字段信息保存到变量中，变量会载入内存，对于内存的速度比磁盘速度更快，因此使用字段定义的功能要比字段缓存效果更加高效
* （2）使用：
``` php
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
```
### 27、TP数据创建（也即是数据接收）
* （1）使用数据模型对象调用create方法可以自动接受表单提交的数据内容并且对数据内容进行过滤操作（根据数据表的结构信息），对于create的功能很多，例如自动验证等
* （2）用法如下：
``` php
  $model = D('user');
    // create可以根据数据表字段过滤数据
    // create默认只能处理post请求提交的数据
    // create($_GET)或者create(I('get.')) 开启create处理get方式请求的数据
    // I函数用于接受表单等提交的参数,I函数接收参数具有安全过滤的功能
    // 添加参数校验后，一旦参数校验不通过，$model->create()就会返回false
    $data = $model->create();
      if ($data) {
        // 判断参数是否校验通过后的做什么
        // 获取模型里面的错误信息$model->getError()方法
          dump($model->getError());
      }
```
### 28、TP中的字段映射
* （1）概念：为了在表单中隐藏真实的数据表字段名称，通常需要在表单中使用假名，
为了确保使用假名后能够使用数据的创建功能，
可以在自定义的数据模型中通过TP提供的基类数据模型里面的固定属性指定具体的假名与真名之间的对应关系，
就叫字段映射
* （2）字段映射的实现：
``` php
  // 字段映射的属性，其数据类型是一个数组，下标表示字段的假命，对应的值就是真名
  // 字段映射后，在表单模板中的字段直接使用假名即可
  // 默认字段映射是由create触发的，因此要想接收到参数，必须用create来接收参数
  protected $_map = array(
    'name' => 'username',
    'nike' => 'nikename',
    '假名...' => '真名...',
  );
```
### 29、TP中对接收参数的自动验证
* （1）在使用create创建数据时自动对具体的提交的数据进行合法性校验操作
* （2）校验规则：
``` php
  /**
  * 验证规则：在附加规则指定验证方式后，根据附加规则指定的方式指定具体的校验规则
  * ①附加规则是regex：验证规则写上具体的正则表达式
  * ②附加规则是function：验证规则写上具体的函数名（可以是PHP内置函数、TP公共函数、自定义的公共函数）
  * ②附加规则是callback：验证规则写上具体的当前模型类下的具体某一个方法名称
  *
  * 验证条件：控制当前的验证规则是否执行，可选有三种条件：
  * ①self::EXISTS_VALIDATE或者0：存在字段就验证（默认）
  * ②self::MUST_VALIDATE或者1：必须验证
  * ③self::VALUE_VALIDATE或者1：值不为空时验证
  * 
  * 附加规则：指定当前的验证规则使用哪一种方式进行验证，常见用的有三种（规则很多）：
  * ①regex：正则验证，定义的验证规则是一个正则表达式（默认）
  * ②function：函数验证，定义的验证规则是一个函数名称
  * ②callback：方法验证，定义的验证规则是当前数据模型类的一个方法
  *
  * 验证时间：控制当前的验证规则具体什么时间生成，具体常用的有一下三种
  * ①self::MODEL_INSERT或者1：新增数据时验证
  * ②self::MODEL_UPDATE或者2：编辑数据时验证
  * ③self::MODEL_BOTH或者3：全部情况下验证（默认）
  * 注意：并非只有这三种，可以根据业务需要增加其他验证时间
  */
  array(
    // []里面的参数代表可选字段,，不在里面的是必天字段
    attar(验证字段名称1，验证规则，错误提示，[验证条件，附加规则，验证时间]),
    ......
  )
  // 静态方式实现自动验证规则,这里的字段名称需要与数据表字段一致，不能使用假名
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
  // 定义项目使用的公共函数，此文件下的函数会自动载入到项目中，并且所有函数可以在项目的任何模块下使用
  function check_nike($nikename)
  {
    $regex = '/[^\u4e00-\u9fa5]/g'; // 匹配不是汉字
    if (preg_match($regex,$nikename)){
      return true;
    } else {
      return false;
    }
```
* （3）静态方式：在模型类中通过$_validate属性定义验证规则（都需要统一定义校验规则）
* （4）动态方式：使用模型类的validate方法动态创建自动校验规则（都需要统一定义校验规则）
### 30、TP中的自动完成功能
* （1）在使用create创建数据时，TP会自动对接受的内容进行增加或者修改的操作
* （2）使用场景①：部分字段在表单中无需用户输入（如数据的插入时间），但是这些字段在数据添加或修改时又需要将对应的内容写入到数据库中
* （3）使用场景②：使用create创建数据后，可能部分数据在格式上不满足要求，就需要将具体的内容转换格式后再写入数据库
* （4）自动完成的使用方式①静态方式：在模型类中通过$_auto属性定义自动处理规则（都需要统一定义处理规则）
* （5）自动完成的使用方式②动态方式：在模型类中通过auto方法动态创建自动处理规则（都需要统一定义处理规则）
* （6）定义归自动处理规则的写法：
``` php
 /**
  * 完成规则：在附加规则指定验证方式后，根据附加规则指定的方式指定具体的校验规则
  * ①附加规则是regex：验证规则写上具体的正则表达式
  * ②附加规则是function：验证规则写上具体的函数名（可以是PHP内置函数、TP公共函数、自定义的公共函数）
  * ②附加规则是callback：验证规则写上具体的当前模型类下的具体某一个方法名称
  * 
  * 完成时间：控制当前的验证规则具体什么时间生成，具体常用的有一下三种
  * ①self::MODEL_INSERT或者1：新增数据时处理（默认）
  * ②self::MODEL_UPDATE或者2：更新数据时处理
  * ③self::MODEL_BOTH或者3：全部情况都处理
  *
  * 附加规则：指定当前的验证规则使用哪一种方式进行验证，常见用的有三种（规则很多）：
  * ①function：函数验证，定义的验证规则是一个函数名称
  * ②callback：方法验证，定义的验证规则是当前数据模型类的一个方法
  */
 array(
  // []里面的参数代表可选字段,，不在里面的是必天字段
    attar(完成字段1，完成规则，[完成时间，附加规则]),
    ......
  )
  // 定义具体自动完成规则
  $auto=array(
    array('addate','time',1,'function')
  );
  // 动态方式创建自动处理规则
  $data = $model->auto($auto)->create();
```
### 31、TP中数据模型基类提供的数据统计查询方法
* （1）Count：统计数量（总行数），参数是要统计的字段名（可选）
``` php
 $model = D('user');
 // 获取行数
 echo $model->count();
 // 获取最大值
 echo $model->max('id');
 // 使用where子语句指定具体条件进行统计查询
 echo $model->where()->max('id');
```
* （2）Max：获取最大值，参数是要统计的字段名（可选）
* （3）Min：获取最小值，参数是要统计的字段名（可选）
* （4）Avg：获取平均值，参数是要统计的字段名（可选）
* （5）Sum：获取总数，参数是要统计的字段名（可选）
### 32、TP模型类中的事物处理实现
* 说明：在同时执行多个sql语句时，如果其中有一条出错，那么整体就不执行修改操作，只有整体不出错才会提交，这就是事物处理，实现如下：
``` php
  // 模型事物处理功能
  $model = D('user');
  $model->startTrans();  // 开启事物处理
  $res1 = $model->where('id=1')->save(array(
    'role'=> '1',
    'tel'=> '18888888888',
  ));
  $res2 = $model->where('id=4')->save(array(
    'heihei'=> '1', // heihei字段不存在
  ));
  if (!$res1 && !$res2){
    $model->commit(); // 都执行成功，则提交事物，确认修改
  } else {
    $model->rollback(); // 否则就回滚事物，不修改
  }
```
### 33、TP中的连贯操作
* （1）连贯操作即在进行数据交互时使用多个方法顺序执行最后在调用一个CURD操作
* （2）最常用的连贯操作方法有：where、field、alias、order、limit等（还有很多）
* （3）连贯操作需要使用模型对象调用具体的连贯方法，可以调用一个也可以调用调用多个，每一个连贯方法调用没有任何的顺序
* （4）连贯操作的使用格式：模型对象->连贯方法->CURD操作方法
* （3）实现：
``` php
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
```
### 34、TP中的连表查询
* 实现：
``` php
  // 实现TP中的连表查询
  $model = D('user');
  // join方法能够实现连表查询功能
  // join指定具体的连表查询条件（首先指定具体的连接方式【左连右连还是内连】、指定具体连接哪一张数据表、
  // 指定具体的连接字段，跟原生SQL的写法一致,如果还需连接更多的表，写生更多的join函数即可
  $data =  M('article')->alias('a')->field('a.*,b.nikename')->join('left join user b on a.user_id=b.id')->limit(3)->select();
  dump($data);
```
### 35、在TP中使用原生SQL语句
* （1）Query：专门针对查询操作（select类型的SQL语句）使用，返回具体的结果集
* （2）Execute：专门针对写入操作（添加、修改、删除）使用，返回具体的受影响的函数
* （3）两个函数的使用方法：模型对象->query/execute(sql语句)
* （4）实现：
``` php
  // 使用原生的sql语句
  $model->query('select * from user');
  $model->execute('insert into user values ()');
```
### 36、TP模型中的钩子函数
* （1）钩子函数即数据操作（写入、删除、修改操作）时会自动触发的方法，对于钩子函数区分前置跟后置之分，前置即数据操作之前会执行，后置即在操作完成之后执行
* （2）写入钩子函数：_before_insert、_after_insert
* （3）修改钩子函数：_before_update、_after_update
* （4）删除钩子函数：_before_delete、_after_delete
* （5）使用案例（一般可以使用在图片上传写入的时候）：
``` php
  // 重写钩子函数
  public function _before_insert(&$data, $options)
  {
    dump($data);
  }

  public function _after_insert($data, $options)
  {
    dump($data);
  }
```
### 37、TP的文件上传  
* 实现：
``` php
  // 模型中：使用模型钩子函数处理图片上传
  public function _before_insert(&$data, $options)
  {
    parent::_before_insert($data, $options); // TODO: Change the autogenerated stub
    // 实现图片上传功能
    // 实例化图片上传对象
    // 关于图片上传的根目录需要手动创建，TP不会自动创建上传的和根目录
    $config = array(
      'exts'          =>array('jpg','gif'), // 配置文件上传的文件后缀名
    );
    $upload = new Upload($config);
    $info = $upload->uploadOne($_FILES['file']);
    if (!$info) {
      $this->error = $upload->getError();
      return false;
    }
    $data['avatar'] = 'Uploads/'.$info['savepath'].$info['savename'];
    dump($data);
  }
  // 控制器中：
  $model = D('Uploads');
  $data = $model->create();
  if(!$data) {
    $this->error($model->getError());
  }
  $res = $model->add($data);
  if (!$res) {
    $this->error($model->getError());
  }
  $this->success('写入数据成功');
```
### 38、TP中的分页功能
* （1）实现：
``` php
  // 在控制器对应的方法中
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
```
### 40、TP的会话技术（cookie及session）
* （1）实现：
``` php
  // TP中使用session
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
```
### 41、TP验证码类的使用
* 实现：
``` php
  // TP验证码类的使用（在控制器中）
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
```

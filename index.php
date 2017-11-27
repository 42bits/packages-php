<?php
/*
有一对兔子，从出生后第3个月起每个月都生一对兔子，小兔子长到第三个月后每个月又生一对兔子，假如兔子都不死，问每个月的兔子总数为多少？
程序分析:
第一个月-----------------1
第二个月-----------------1
第三个月-----------------2
第四个月-----------------3
第五个月-----------------5
第六个月-----------------8
第七个月-----------------13
*/
function robot($n){
	for($i = 1;$i<=$n ;$i++){
		if($i ==1 || $i == 2){
			$arr[$i] = 1;
		}else{
			$arr[$i] = $arr[$i-1]+$arr[$i-2];
		}
		print_r($arr[$i].PHP_EOL);
	}
}
echo  robot(24);

/*
单引号和双引号的区别
双引号解释变量，单引号不解释变量
*/

/*
常用的超全局变量
$_GET,$_POST,$_GOLBALS,$_FILE,$_SERVER,$_SESSION,$_COOKIE,$_REQUEST
*/

/*
HTTP中 GET POST PUT DELETE区别
HTTP定义了与服务器的交互方式，url为网络资源描述符，这些就是对他的增删改查的操作
*/

/*
表单中get和post区别
提交方式不一样，get参数拼接到action的url后面，post参数通过添加到head中传过去
get数据量受限制，post一般不受限制
*/

/*
echo print print_r var_dump 区别
echo 输出一个或多个字符串，用逗号间隔，没有返回值，print 打印简单的变量值，有返回值，print_r打印复杂的变量，var_dump也可以打印复杂的变量，并且会返回变量类型
*/

/*
HTTP状态码
1* 服务器受到请求，需要请求者继续执行操作
2* 服务器成功处理请求并返回处理结果
3* 重定向，需要进一步的操作完成操作
4* 客户端错误，请求语法错误或无法完成请求
5* 服务端错误，在处理请求是发生错误

200 请求成功，302永久重定向，401 需要用户验证，403 资源不可用，404 请求资源不存在，500内部服务器错误，501 服务器不支持实现请求所需要的功能。例如，客户发出了一个服务器不支持的PUT请求 503 网关不可用 504 网关超时

*/

/*
魔术引导
打开时所有的单引号，双引号，反斜线，null 都会自动加上反斜线进行转义，和addslashes()功能相同，至5.4已经废弃该方法不在使用
*/

/*
客户端ip(一个int型)和服务器ip
$_SERVER['REMOTE_ADDR'],ip2long(),gethostbyname();
*/

/*
大流量网站采用什么方式来提升性能
添加负载均衡，添加缓存，数据库分离，页面静态化
*/

/*
include和require区别
include 如果文件不存在会提示一个错误但继续执行，执行到才会加载
require遇到错误会停止执行，一开始就会加载
*/

/*
文件上传
默认是2M; upload_max_filesize(); post_max_size();
*/

/*
js定时跳转
setTimeout(function(){},5000);
*/

/*
url?之后的内容
$_SERVER['QUERY_STRING'];
*/

/*
传值和传引用的区别
按值，函数范围内的改变在函数外都是无效的，反之
按值，传递必须复制，如果特别大，会很耗性能，
*/

/*
PHP中获取图像尺寸大小的方法是什么？
getimagesize(),imagesx 宽，imagesy 高
*/

/*
PHP中的错误类型有哪些？
提示，警告，错误
*/

/*
如何在PHP中定义常量
define()
*/

/*
PHP的8种数据类型
整形，字符，浮点，boole，数组，对象，null，resource
*/

/*
php如何获得浏览器信息
$_SERVER[HTTP_USER_AGENT];
*/



/*
如何遍历一个文件夹下所有的内容
*/

function my_scandir($dir){
        $files = array();
        if(is_dir($dir)){
            if ($handle = opendir($dir)) {
                while (($flie = readdir($handle))!== false) {
                    if ($flie!="." && $file!="..") {
                        if (is_dir($dir."/".$file)) {
                            $files[$file] = my_scandir($dir."/".$file);
                        } else {
                            $files[] = $dir."/".$file;
                        }
                    }
                }
                closedir($handle);
                return $files;
            }
        }
    }


$dir = 'D:\TEST';
function list_file($dir){
	if(is_dir($dir)){
		$list = scandir($dir);
		foreach($list as $v){
			if($v != '.' && $v !='..'){
				if(is_dir($dir.'/'.$v)){
					list_file($dir.'/'.$v);
				}
				echo  $dir.'/'.$v.PHP_EOL;
			}
		}
	}
}
list_file($dir); 



/*
二分法
*/
$a = array(222,99,98,7,100,9,111,30); 
sort($a);

function dis($arr,$start,$end,$var) {	
     $mid = intval(($start+$end)/2);  
     if($arr[$mid] == $var){  
        return $mid;  
     }elseif($arr[$mid] > $var){
         return dis($arr,$start,$mid-1,$var);  
     }else{
         return dis($arr,$mid+1,$end,$var);  
     }  
}
echo dis($a,0,count($a),7).PHP_EOL;

/*
从小到大冒泡
*/

$arr = array(222,99,98,7,100,9,111,30); 
function mao($arr){
	$len = count($arr);
	for($i=0;$i<$len;$i++){
		for($j=$i;$j<$len;$j++){
			if($arr[$j] < $arr[$i]){
				$tmp = $arr[$i];
                $arr[$i] = $arr[$j];
				$arr[$j] = $tmp;
			}
		}
	}
	return $arr;
}
print_r(mao($arr)).PHP_EOL;

/*
php常用数组和字符串函数
in_array();is_array();array_keys();array_key_exists();array_values();
array_diff();array_merge();array_slice();array_search();
sort();rsort();asort();arsort();ksort();krsort();
import();explode();
substr();mb_substr();strlen();strpos();str_replace();strrev();strip_tags();trim();
strtolower();strtoupper();
array_push();array_pop();array_shift();array_unshift();

*/

/*
获取一个网页的内容,获取文件内容，比如获取www.sina.com.cn的内容
file_get_contents();fopen();fwrite();curl();
*/

/*
如何实现PHP的安全最大化？xss 跨脚本攻击，sql注入
使用htmlspecialchars();对内容过滤
使用addslashes()进行sql语句转换，
不对外展示任何服务器和程序设计上的错误关闭错误显示，不要相信用户的任何输入要过滤，统一使用一个文件入口
*/

/*
php 网站主要攻击方式
命令注入，sql，xss,session劫持，上传漏洞，目录穿越，表单欺骗攻击，url攻击
*/

/*
单一入口和多入口
利于权限控制和安全性检查
*/

/*
存储引擎
myisam innodb csv merge
*/

/*
面向对象
是一种设计模式，利于代码的重用性，清晰，有封装 继承，多态特性
单一，替换，依赖，接口，开闭原则
*/

/*
原样输出用户输入的内容，使用哪一个函数
htmlspecialchars();
*/

/*
静态和非静态的区别
静态可以不用实例化就可以调用，静态常驻内存，
*/

/*
如果你需要得到脚本执行时的时间
$_SERVER['REQUEST_TIME'];
对于比较大的字符串在存入数据库之前可以使用gzcompress先进行压缩,前提应该是不需要检索的情况下吧
gzcompress();
使用ip2long将ip地址转化成整形存入数据库，可节省存储空间
ip2long();
$row['id']比$row[id]速度快7倍 建议养成数组键加引号的习惯
switch case好于使用多个if，else if语句,并且代码更加容易阅读和维护
使用file_get_contents 代替file fopen feof fgets 
用 $i+=1 代替 $i = $i+1;
使用 blobal变量，用完后要unset();
脚本执行时间
php_execuation_time();
使用内存消耗
memory_get_usage();
内存设置
memory_limit();
上传文件大小
upload_file_filesize;
*/

/*
屏蔽php错误
error_reporting(E_ALL^E_NOTICE^E_WARNING);
display_error = no
@
*/

/*
打开错误
error_reporting(2047);
*/

/*合并数组
array_merge();相同的键会覆盖
array_merge_recursive();
*/

/*
字符 字节 汉字 英文字符等等的关系
字符为计算机中使用的文字和符号
字节是计算机存储单位
一个字节=8个二进制
utf-8中，一个英文 一般一个字节，一个汉字 一般3个字节
*/

/*
isset和empty的区别
isset() 检测变量是否设置（变量不存在或存在但是值为null 返回 false）
empty() 检测变量是否为空（值为 null 0 "0" array() false 返回 true）
*/

/*
将字符串abcdef 翻转的函数
strrev();
*/
$str = '123456789';
function my_strrev($str){
	$strs = '';
	$str = str_split($str);
	for($i=count($str)-1; $i>=0;$i--){
		$strs .= $str[$i];
	}
	echo $strs.PHP_EOL;
}
my_strrev($str);

/*
多服务器之间Session共享
 服务器之间session同步，数据库，利用NFS共享session方式，也可以通过cookie和curl配合
*/

/*
魔术方法
_construct();__destruct();__get();__set();__call();__clone();__sleep();
*/
/*
数据库优化
字段设计
能用数字型字段就用数字型字段，能用char 就用 char
where频繁的添加索引，如果是性别之类的加了效果不大
依据情况分表分库
sql语句优化
*/

/*
sql语句优化
只取需要的字段，对频繁查询的条件添加索引，where中尽量不要使用 != ,<>,or,like模糊查询，右模糊会使用索引
能用between 就不要用in，
对where 字段进行函数操作也会导致索引失效，select id from t where num/2=100应修改为select id from t where num=100*2，select id from t where substring(name,1,3)='abc' 应改成select id from t where name like 'abc%'
使用复合索引，where语句应该和索引的顺序一致，
*/

/*
memcache和Redis的区别
redis数据不是一直存储在内存中，可以保存在文件中
*/

/*
Apache与Nginx的优缺点比较
nginx占用更少的内存及资源，高度模块化设计
nginx 处理请求是异步非堵塞，多个链接可以对应一个进程，apache则是堵塞型，是同步多进程模型，nginx处理静态资源比apache高
apache 模块稳定和多，nginx使用epoll和kqueue 网络i/o模型 ，apache使用的select
*/

/*
cgi和fastcgi区别
fastcgi在接受到请求后不会fork一个进程，会把这个请求直接给这个进程，处理完返回结果给服务器，然后等待下一个请求，
cgi在接受到请求后会fork一个进程，处理完就结束进程
*/

/*
php当前脚本路径 $_SERVER['PHP_SELF'];
*/


/*
abstract 和interface的区别
都不能被实例化
abstract 可以定义方法也可以实现方法，如果只定义方法，那么就退化成了接口和interface一样
interface 之可以定义方法
抽象类的方法可以不在子类中实现，也可以被重写，而接口所有方法，一定要全部实现
一个class只能继承一个abstract class 但是可以实现多个interface class 
一般来讲，抽象用于不同的事物，接口用于事物的行为，
如：水生生物是鲸鱼的抽象概念，但是水生生物并不是鲸鱼的行为，吃东西才是鲸鱼的行为。
如果用abstract 可以定义类对象的属性，即描述他是干什么的，而interface类似于插件，侧重于提供附件功能，约定他能做什么，
比如：提供报警功能的门class继承了门abstract这个基础（有打开和关闭两个方法）并实现了报警器interface接口。
*/

/*
traits特性
可以更方便的实现代码复用，使用多个traits时要避免命名重复，
不仅仅是复用代码的集合，也应该是一组描述了某个特性的属性和方法的集合
优点是组合随意，耦合性低，可读性高
 类似于 include 可以在类中 通过 use 引用，
*/

/*
索引，主键，唯一索引，联合索引
索引是一种文件，包含对数据库所有记录的引用指针
普通索引，目的增加数据获取速度，允许有重复值，唯一索引不允许
主键，特殊的唯一索引，用primary key 创建auto_increment 自增
多个列一起创建一个索引，为联合索引
*/

/*???
面向对象的理解
hash的理解
队列的原理和使用场景
http协议
*/

/*
php常用设计模式、应用场景使用及其优势
http://m.blog.csdn.net/flitrue/article/details/52614599
单例模式：创建唯一对象实例。数据库类
工厂模式：您可以使用工厂类创建对象，而不直接使用 new，可以避免当改变某个类的名字或者方法之后，在调用这个类的所有的代码中都修改它的名字或者参数
观察者模式：当一个对象状态发生变化时，依赖它的对象全部会收到通知，并自动更新
注册数模式：注册模式，解决全局共享和交换对象。已经创建好的对象，挂在到某个全局可以使用的数组上，在需要使用的时候，直接从该数组上获取即可
适配器模式：将各种截然不同的函数接口封装成统一的API。 
策略模式：将一组特定的行为和算法封装成类，以适应某些特定的上下文环境

*/
/*
组合和聚合的区别
组合：A类在实例化对象的过程中产生了对B类的引用
聚合：A类在实例化对象的过程中，不会立即实例化B类，而是等待外界非A类的对象传递
*/
/*
多进程/线程同时读写一个文件的问题
*/
$file = 'D:\TEST\TEST\EEE\test.txt';
function my_read($file){
	$fp = fopen($file,"a");
	if(flock($fp,LOCK_EX)){
		fwrite($fp,'eeeee');
		flock($fp,LOCK_UN);
	}
	fclose($fp);
}
my_read($file);

/*
mysql 的存储引擎,myisam和innodb的区别
myisam 不支持高级的的事物处理，myisam 查询速度很快，myisam 是表锁，innodb是行锁，myisam保存总行数，innodb不会保存，每次都要扫描怎个表来统计，
*/

/*
mySQL数据库作发布系统的存储，一天五万条以上的增量，预计运维三年,怎么优化
选择合适的字段和添加索引，书写合适的sql语句，添加缓存，mysql 主从分离，按规律分表。
*/

/*
写出一个正则表达式，过虑网页上的所有js/VBS脚本（即把标记及其内容都去掉）
$prex = "/<script[^>]*?>.*?</script>/si";
email：
$prex = "/^(\w)+([-+.]\w+)*@(\w)+((\.\w+)+)$/si";
prege_match($prex,$email);
*/

/*
MVC 优点缺点
缺点：增加了系统结构的复杂，视图和控制器过于紧密，视图对模型的使用效率低，
优点：业务和视图分离，维护性提高，开发效率提高
*/

/*
HTTP Keep-Alive的作用
保持客户端到服务端的链接有效不必在握手建立链接，对于提供静态资源的网站很有用，
keep-alive：timeout=5，max=100 
*/

/*
不用新变量直接交换现有两个变量的值
list($a,$b) = array($b,$a);
*/

/*
heredoc
常用来输出大量html;
以<<<END开头，END结束,顶格写
*/

/*
禁掉cookie的session使用方案，设置session过期的方法，对应函数
可以通过url带session_id过去，或用文件和数据库保存session_id
setcookie()设置session_id过期时间,ini中session.gc_maxlifttime 设置
*/

/*
json格式数据有哪些特点
 易于阅读和书写，基本上所有语言都适用，
*/

/*
常量
__LINK__;__FILE__;__DIR__;__CLASS__;__METHOD__;__NAMESPACE__;
*/

/*
有mail.log的一个文档，内容为若干邮件地址，用’\n’分隔换行。挑选sina.com的地址（包括从文件读取、过滤到列印出来）
cat mail.log |grep sina.com
*/

/*
PHP缓存技术有哪些?
全页面缓存；部分缓存；数据缓存；查询缓存；
*/

/*
尽可能高效的从一个标准url中取出扩展名
parse_url();pathinfo($file,PATHINFO_EXTENSION);
*/

/*
safe mod 关闭影响函数，在php5.4以上版本，则将此特性完全去除了
move_uploaded_file();fopen();unlink();touch();mkdir();chmod();copy();exec();system();
*/

/*
js弹窗，alert();confirm();焦点，focus();
*/

/*
mysql_fetch_row() 和mysql_fetch_array之间有什么区别
mysql_fetch_row()从结果集中取得一行作为数字数组，
mysql_fetch_array()是mysql_fetch_row升级版，从结果集中取得一行作为关联数组和数字数组
*/

/*
猴子选大王
*/
function monkey($n,$m){
	$arr = range(1,$n);
	$i = 0;
	
	while(count($arr) >1){
		if(($i+1) % $m == 0){
			unset($arr[$i]);
		}else{
			array_push($arr,$arr[$i]);
			unset($arr[$i]);
		}
		$i++;
	}
	print_r($arr);
}
monkey(15,12);

/*
两个文件的相对路径
*/
    function releative_path($path1,$path2){
        $arr1 = explode("/",dirname($path1));
        $arr2 = explode("/",dirname($path2));

        for ($i=0,$len = count($arr2); $i < $len; $i++) {
            if ($arr1[$i]!=$arr2[$i]) {
                break;
            }
        }

        // 不在同一个根目录下
        if ($i==1) {
            $return_path = array();
        }

        // 在同一个根目录下
        if ($i != 1 && $i < $len) {
            $return_path = array_fill(0, $len - $i,"..");
        }

        // 在同一个目录下
        if ($i == $len) {
            $return_path = array('./');
        }

        $return_path = array_merge($return_path,array_slice($arr1,$i));
        return implode('/',$return_path);
    }

    $a = '/a/b/c/d/e.php';
    $b = '/a/b/12/34/c.php';
    $c = '/e/b/c/d/f.php';
    $d = '/a/b/c/d/g.php';

    echo releative_path($a,$b);//结果是../../c/d
    echo "<br />";
    echo releative_path($a,$c);//结果是a/b/c/d
    echo "<br />";
    echo releative_path($a,$d);//结果是./
    echo "<br />";

#如何把一个GB2312格式的字符串装换成UTF-8格式？
	iconv('GB2312','UTF-8','悄悄');

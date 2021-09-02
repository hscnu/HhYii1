<?php
//include_once dirname(__FILE__).'/../../../../qmddpack/qmddpackinit.php';
/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    $str = trim(clear_html(str_replace('&nbsp;', '', strip_tags($str))));
    if (mb_strlen($str) > $length) {
        $isSuffix = true;
    } else {
        $isSuffix = false;
    }
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {
            $slice = '';
        }
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    if ($str == $slice) {
        return $slice;
    } else {
        return $suffix && $isSuffix ? $slice . '…' : $slice;
    }
}

function substr_hz($str,$start,$len=0){
    if ($len==0){
        $len=strlen_hz($str)-$start;
    }
    return mb_substr($str,$start,$len,'UTF-8');
}
function subsstr_hz($str,$start,$len=0){
    if ($len==0){
        $len=strlen_hz($str)-$start;
    }
    return mb_substr($str,$start,$len,'UTF-8');
}

function strlen_hz($str){
    return mb_strlen($str,'UTF-8');
}

//将内容进行UNICODE编码
function unicode_encode($name)
{
    $name = iconv('UTF-8', 'UCS-2', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {  // 两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}
function unicode_decode($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}



/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0) {
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL)
        return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos)
            unset($arr[$pos]);
        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function show_status($status, $msg = '', $redirect = '',$msg2 = '', $redirect2 = '') {
    if ($status) { ajax_status(1, $msg, $redirect);
    } else {
        ajax_status(0, $msg2, $redirect2);
    }
}

function ajax_status($status = 0, $msg = '', $redirect = '') {
    ajax_exit(array('status' => $status, 'msg' => $msg, 'redirect' => $redirect));
}

function ajax_exit($arr) {
    header('Content-type:application/json');
    echo array_str($arr);
    exit;
}

function array_str($arr) {
    return CJSON::encode($arr);
}
/**
 * 设置cookie
 * @param string $name 名称
 * @param mixed $value 值
 * @param integer $day 有效天数
 * @return string
 */
function set_cookie($name, $value, $day = 1) {
    $cookie = new CHttpCookie($name, $value);
    $cookie->expire = time() + 60 * 60 * 24 * $day;
    Yii::app()->request->cookies[$name] = $cookie;
}

/**
 * 获取cookie
 * @param string $name 名称
 * @return mixed
 */
function get_cookie($name) {
    $cookie = Yii::app()->request->getCookies();
    if (null === $cookie[$name]) {
        return null;
    }
    return $cookie[$name]->value;
}

/**
 * 删除cookie
 * @param string $name 名称
 */
function del_cookie($name) {
    $cookie = Yii::app()->request->getCookies();
    unset($cookie[$name]);
}

function get_session($name) {
    $rs=0;
    if(!isset($_SESSION)){ session_start();}
    if (isset($_SESSION[$name])){ $rs=$_SESSION[$name];}
    if (isset(Yii::app()->session[$name])){
        $rs=Yii::app()->session[$name] ;}
    return $rs;
}

function get_year() {
    return 2020;
}

function get_term() {
    return get_session('term');
}

function get_school() {
    return get_session('school');
}

function get_level() {
    return get_session('level');
}

function get_name_where($w,$name,$sname) {
    if(!empty($name)){
        $w1=get_session($sname);
        $w1=( $w1=='0') ? '': $w1;
        $w=get_where( $w,!empty($w1),$name,$w1,"'");
    }
    return $w;
}

function set_class($name,$value) {
    Yii::app()->session[$name]=$value;
}
/**
 * 把返回的不同表的字符条件
 */
function get_school_where($w,$school,$level,$class,$year,$term){
    $w1=get_name_where($w,$school,'school');
    $w1=get_name_where($w1,$level,'level');
    $w1=get_name_where($w1,$class,'class');
    $w1=get_name_where($w1,$year,'year');
    return get_name_where($w1,$term,'term');
}

function set_school_name_where($name,$sname) {
    if(!empty($name)){
        if(!isset($_REQUEST[$name]))  { $_REQUEST[$name]='';}
        $s1=$_REQUEST[$name];
        if(empty($s1) ||($s1='0')){
            $_REQUEST[$name]=get_session($sname);
        }
    }
}

function get_school_name($name,$sname) {
    if(empty($name)){
        $name=get_session($sname);
    }
    return $name;
}
function set_school_combos(){
    $school=School::model()->find();
    $years=Yearlist::model()->findALL();
    $terms=Term::model()->findALL();
    $levels=Level::model()->findALL();
    $class=BaseCode::model()->getClass();
    $tclass=get_session('class_teacher');
}
function get_school_resquest(&$school,&$level,&$class,&$year,&$term){
    //set_school_combos();
    $school=get_school_name($school,'school');
    $level=get_school_name($level,'level');
    $class=get_school_name($class,'class');
    $year=get_school_name($year,'year');
    $term=get_school_name($term,'term');
}

function set_school_resquest($school,$level,$class,$year,$term){
    set_school_name_where($school,'school');
    set_school_name_where($level,'level');
    set_school_name_where($class,'class');
    set_school_name_where($year,'year');
    set_school_name_where($term,'term');
}

function check_admin(){
    set_school_name_where($school,'school');
    set_school_name_where($level,'level');
    set_school_name_where($class,'class');
    set_school_name_where($year,'year');
    set_school_name_where($term,'term');
}

function set_session($name,$pvalue) {
    $rs=0;
    if(!isset($_SESSION)){ session_start();}
    $_SESSION[$name]=$pvalue;
}

function get_stsnum(){
    if(isset($_REQUEST['stsnum'])){
        if($_REQUEST['stsnum']>190000){
            set_session('STSNUM',$_REQUEST['stsnum']);
        }
    }
    return get_session('STSNUM');
}
/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = & $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = & $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = & $refer[$parentId];
                    $parent[$child][] = & $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param string $path 缓存路径
 * @return mixed
 */
function file_cache($name, $value = '', $path = ROOT_PATH) {
    static $_cache = array();
    $filename = $path . '/' . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name, '*') ? array_map("unlink", glob($filename)) : unlink($filename);
        } else {
            // 缓存数据
            $dir = dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir, 0755, true);
            $_cache[$name] = $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value = include $filename;
        $_cache[$name] = $value;
    } else {
        $value = false;
    }
    return $value;
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $strict = true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

function mk_dir($path, $mode = 0755) {
    if (!file_exists($path)) {
        mk_dir(dirname($path), $mode);
        mkdir($path, $mode);
    }
}

function encrypt($str, $salt = '') {
    return md5($str . '!@#$%' . $salt . '^&*()');
}

function clear_html($content) {
    $content = preg_replace("/<a[^>]*>/i", "", $content);
    $content = preg_replace("/<\/a>/i", "", $content);
    $content = preg_replace("/<div[^>]*>/i", "", $content);
    $content = preg_replace("/<\/div>/i", "", $content);
    $content = preg_replace("/<!--[^>]*-->/i", "", $content); //注释内容
    $content = preg_replace("/style=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/class=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/id=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/lang=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/width=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/height=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/border=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/face=.+?['|\"]/i", '', $content); //去除样式
    $content = preg_replace("/face=.+?['|\"]/", '', $content); //去除样式 只允许小写 正则匹配没有带 i 参数

    return $content;
}

// discuz 加密解密函数
function authcode($string, $operation = 'DECODE', $key = 'wzg', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

function urlauthcode($string, $operation = 'DECODE', $key = 'zsylwzg888', $expiry = 0) {
    if ($operation == 'DECODE') {
        $string = base64_decode($string);
        return authcode($string, $operation, $key, $expiry);
    } else {
        return base64_encode(authcode($string, $operation, $key, $expiry));
    }
}

function https_request($url) {
    if (function_exists('curl_init')) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return null;
        }
        curl_close($curl);
        return $data;
    } else {
        if (file_exists($url)) {
            $data = file_get_contents($url);
            return $data;
        } else {
            return null;
        }
    }
    return null;
}

function getTime(){
    $time = explode ( " ", microtime () );
    $time = "".($time [0] * 1000);
    $time2 = explode ( ".", $time );
    $time = $time2 [0];
    $s1=str_replace('-','',get_date());
    $s1=str_replace(':','',$s1);
    $s1=str_replace(' ','',$s1);
    return $s1.$time;
//2010-08-29 11:25:26
}

function timeToFilename(){
    return getTime();
//2010-08-29 11:25:26
}

function getUploadPath($pid=124){
    return BasePath::model()->getPath($pid);
}

function delUploadPath($str){
    return BasePath::model()->reMovePath($str);
}
function addUploadPath($str){
    return BasePath::model()->addPath($str);
}

function getWwwPath(){
    return BasePath::model()->getWwwPath();
}

function getLocalPath(){
    return BasePath::model()->getLocalPath();
}


function get_short_path(){
    $ymd = date("Ymd");
    $yy=  substr($ymd,0,4);
    $yy.='/'.substr($ymd,4,2);;
    $yy.='/'.substr($ymd,6,2);
    return $yy.'/';
}

function get_date(){
    return date('Y-m-d h:i:s',time());
}
function get_file_name($key=""){
    return get_short_path().getTime();
}
//保存文件
function post_upload_file($filename, $content, $prefix = '', $ext = 'html') {
    // 保存到远程服务器接口
    if(empty($filename)){
        $filename=get_file_name().'.'.$ext;
    }
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'content-type:application/octet-stream',
            'content' => $content,
        ),
    );
    $file = stream_context_create($options);
    $json_rs = file_get_contents(Yii::app()->params['uploadUrl'] . '?fileCode=' . $prefix . '_&fileType=' . $ext . '&oldfilename=' . $filename, false, $file);
    $rs = json_decode($json_rs, true);
    return $rs;
}

function sql_find($sql){
    return $sql;
}

function sql_findone($sql){
    $connection=Yii::app()->db;
    return $connection->createCommand($sql)->queryOne();
}

function sql_findall($sql){
    $connection=Yii::app()->db;
    return $connection->createCommand($sql)->queryAll();
}
// 返回多行. 每行都是列名和值的关联数组.
// 如果该查询没有结果则返回空数组
//$posts = Yii::$app->db->createCommand('SELECT * FROM post')->queryAll();

// 返回一行 (第一行)
// 如果该查询没有结果则返回 false
//$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=1')
//          ->queryOne();

// 返回一列 (第一列)
// 如果该查询没有结果则返回空数组
//$titles = Yii::$app->db->createCommand('SELECT title FROM post')
//             ->queryColumn();

// 返回一个标量值
// 如果该查询没有结果则返回 false
//$count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM post')
//             ->queryScalar();

function set_html($file, $content, $basepath = null, $strtr = array()) {
    $prefix = '';
    if ($basepath != null) {
        $content = strtr($content, array($basepath->F_WWWPATH => '<gf><gf>'));
        $prefix = $basepath->F_CODENAME;
    }
    if (!empty($strtr)) {
        $content = strtr($content, $strtr);
    }

    $htmlHeader = <<<EF
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
<style>
*{
    margin:0;
    padding:0;
    -webkit-tap-highlight-color:rgba(0,0,0,0);}
img{
  max-width:100%;}
body{
  line-height:1.8;
  font-size:20px;
  color:#000;
  -webkit-text-size-adjust:none;
  -o-text-size-adjust:none;
  text-size-adjust:none;
  background:#fff;}
.qmdd-wrapper{}
</style>
<script type="text/javascript">
    window.onload = function() {
        var h  = document.body.scrollHeight;
        parent.postMessage(h, "http://gf41.cn:8090/");
    }
</script>
</head>
<body>
<div class="qmdd-wrapper">
<!--详情开始--->
EF;
    $htmlFooter = <<<EF
<!--详情结束--->
</div>
</body>
</html>
EF;

    $rs = post_upload_file($file, $htmlHeader . $content . $htmlFooter, $prefix, 'html');
    return $rs;
}

// $file 文件完整路径
// $path 替换内容中占位符的路径
function get_html($file, $basepath = null, $strtr = array()) {
    if (check_file_exists($file)) {
        $content = file_get_contents($file);
        $rs = preg_match('%<!--详情开始--->(.*?)<!--详情结束--->%si', $content, $matches);
        if (!$rs) {
            return '';
        } else {
            $content = $matches[1];
        }
        if ($basepath != null) {
            $content = strtr($content, array('<gf><gf>' => $basepath->F_WWWPATH));
        }
        if (!empty($strtr)) {
            $content = strtr($content, $strtr);
        }
        return $content;
    } else {
        return '';
    }
}

function getimages($str) {
    preg_match_all('/<img[^>]*src\s*=\s*([\'"]?)([^\'" >]*)\1/isu', $str, $src);
    return $src[2];
}

function round_dp($num, $dp) {
    $sh = pow(10, $dp);
    return (round($num * $sh) / $sh);
}

//size()  统计文件大小
function size($byte) {
    if ($byte < 1024) {
        $unit = "B";
    } else if ($byte < 1048576) {
        $byte = round_dp($byte / 1024, 2);
        $unit = "KB";
    } else if ($byte < 1073741824) {
        $byte = round_dp($byte / 1048576, 2);
        $unit = "MB";
    } else {
        $byte = round_dp($byte / 1073741824, 2);
        $unit = "GB";
    }

    $byte .= $unit;
    return $byte;
}

function pass_md5($ec_salt,$pass){  return empty( $ec_salt ) ? md5( $pass ) : md5( md5( $pass ) . $ec_salt );}

function get_basename($filename) {
    return substr($filename, 0, -strlen(strrchr($filename, '.')));
}

//判断文件是否存在
function check_file_exists($url) {
    $curl = curl_init($url);
// 不取回数据
    curl_setopt($curl, CURLOPT_NOBODY, true);
// 发送请求
    $result = curl_exec($curl);
    $found = false;
// 如果请求没有发送失败
    if ($result !== false) {
// 再检查http响应码是否为200
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($statusCode == 200) {
            $found = true;
        }
    }
    curl_close($curl);

    return $found;
}

function send_request($url, $paramArray, $method = 'POST', $timeout = 10) {

    $ch = curl_init();

    if ($method == 'POST') {
        $paramArray = is_array($paramArray) ? http_build_query($paramArray) : $paramArray;
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $paramArray);
    } else {
        $url .= '?' . http_build_query($paramArray);
    }

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if (false !== strpos($url, "https")) {
        // 证书
        // curl_setopt($ch,CURLOPT_CAINFO,"ca.crt");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    }
    $resultStr = curl_exec($ch);
    $result = json_decode($resultStr, true);
    return ($result) ? $result : $resultStr;
}

function get_data_from_url($purl,$post_data){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $purl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取数据返回  true
    curl_setopt($ch, CURLOPT_POST, 1); //POST数据// 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //post变量true
    $dat = curl_exec($ch);
    curl_close($ch);
    return json_decode($dat, true);
}

function notify_conten_url(){
    $notify_io_rul="http://qmdd.gf41.cn:8090/QMDD_MQTT_WEB_CLIENT/notifyServlet"; //通知系统接口
    return  $notify_io_rul;
}

function send_message($sgfid,$rgfid,$message,$post_data="")
{
    $ms= notify_conten_url().$message;
    $ms.="&targetGfid=".$rgfid;
    $ms.="&sourceGfid=".$sgfid;
    return send_request($ms,$post_data);
}

function send_msg($scode,$sourceGfid,$targetGfid,$sendArr)
{
    $sendArr['notifyTime']=get_date();
    $notify_content=json_encode($sendArr);
    $save_buf=base64_encode($notify_content);
    $post_data=array("action"=>'notify',"targetGfid"=>$targetGfid,"sourceGfid"=>$sourceGfid,"S_G"=>0,
        "channel_id"=>$scode,"lParm"=>0,"notify_content"=>$notify_content,"save_buf"=>$save_buf);
    $s2= get_data_from_url(notify_conten_url(),$post_data);
    return $s2;
}

function system_message($targetGfid,$message)
{
    $sendArr=array("type"=>"系统通知","pic"=>"","title"=>$message,"content"=>"系统通知","url"=>"");
    return send_msg(1001,0,$targetGfid,$sendArr);
}

function send_password($targetGfid,$password)
{
    return system_message($targetGfid,"后台登录密码：".$password);
    //return $this-> invite_club_member($club_id,$projctid,$rgfid,-1,320);
}

//f($action==301){//俱乐部邀请成员加入
function invite_club_member($club_id,$rgfid,$sendArr)
{
    $sendArr['club_id']=$club_id;$sendArr['append_buf']="邀您加入本俱乐部";
    $sendArr['member_type']="0";
    return send_msg(301,$club_id,$rgfid,$sendArr);
    // $sendArr=array("club_name"=>"俱乐部名称","project_name"=>"太极拳",
    //     "project_id"=>"29","club_created_gfid"=>"30",
    //     "club_created_account"=>"669967","club_logo"=>"1451038023332_898.jpg");
}
// else if($action==302){//被我邀请的人同意或拒绝俱乐部入会邀请
//f($action==301){//俱乐部邀请成员加入
function member_into_club($club_id,$rgfid,$sendArr)
{
    return send_msg(302,$club_id,$rgfid,$sendArr);
    // $sendArr=array("invited_gfid"=>"30","invited_gfaccount"=>"669967","invited_gfnick"=>"阿菜","operate_state"=>"0","project_id"=>"38","project_name"=>"太极拳","notifyTime"=>$notifyTime);
}

//解除会员if($action==320){ //社区单位资质人解聘消息
function deinvite_club_member($club_id,$rgfid,$sendArr)
{
    return send_msg(302,$club_id,$rgfid,$sendArr);
    //return $this-> invite_club_member($club_id,$projctid,$rgfid,-1,320);
}

//社区单位收到应聘通知（资质人申请加入某社区）($action==319
function invite_member($club_id,$projctid,$rgfid,$sendArr)
{
    return send_msg(319,$club_id,$rgfid,$sendArr);
    $sendArr=array("qualificate_num"=>"TS-C0-2015-02321","gfid"=>"30","gfaccount"=>"669967","qname"=>"张三丰","phone"=>"13098765678","address"=>"海南文昌","project_id"=>"27","project_name"=>"太极拳","notifyTime"=>$notifyTime);
    invite_member(1,188,132,$sendArr);
    // $sendArr=$p_clublist->get_invite($club_id,$projctid,$rgfid,$itype);
    // return $this-> send_msg($opcode,$club_id,$rgfid,$sendArr);

}


//if($action==323){ //会员等级变更通知
function level_member_change($club_id,$rgfid,$sendArr)
{
    // $sendArr=array("gfid"=>$rgfid,"gfaccount"=>"669967",
    //   "changeLevel"=>$old_level,"changedNum"=>$new_level,
    //  "project_id"=>$projctid,"project_name"=>"太极拳");
    return send_msg(323,$club_id,$rgfid,$sendArr);

}
//if($action==324){ //社区单位向某应聘资质人发出面试邀请
function invite_qualificate_member($club_id,$rgfid,$sendArr)
{
    return send_msg(324,$club_id,$rgfid,$sendArr);
    /* "club_id": "23", //俱乐部ID
        "club_name":"小小俱乐部", //俱乐部名
        "club_logo": "xxxx.jpg", //俱乐部缩略图
        "club_phone":"13098765678",// 俱乐部电话
        "customer_gfid":"30",//客服GFID
        "customer_gfaccount":"669967", //客服帐号
        "customer_gfnick":"阿菜"//客服昵称*/
    $sendArr=array("club_id"=>"23","club_name"=>"俱乐部","club_logo"=>"xxxx.jpg","club_phone"=>"13098765678","customer_gfid"=>"30","customer_gfaccount"=>"669967","customer_gfnick"=>"阿菜");
}


//查找字符的位置，-1表示没找到
function indexof($string,$find,$start=0){
    $pos=strpos($string,$find,$start);
    if($pos === false) { $pos=-1;}
    return $pos;
}


function get_web_path(){
    $s1 =get_service_path();
    $r1=indexof($s1,'hkyg');
    $path =$s1;
    if ($r1>=0) $path=substr($s1,0,($r1-1));
    return $path;
}

function get_service_path(){
    $p1='HTTP_X_FORWARDED_HOST';
    $s1 = isset($_SERVER[$p1]) ? $_SERVER[$p1] : (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
    return $s1;
}

function get_yii_path(){
    return get_web_path()."/hkyg/";
}

function get_tmp_path(){
    return str_replace('\\','/',realpath(dirname(__FILE__).'/../')).'/uploads/temp/';
}

function save_excel_file($dtype=0){
    return (($dtype) ? "/hkyg/uploads/temp/" : get_tmp_path()).'aa1.xls';
}

function get_upload_path(){
    return get_web_path()."/hkyg/uploads/image/";
}

function dele_path(){
    return get_web_path()."/hkyg/uploads/image/";
}

// 原来条件，现在条件，属性名，值，前缀名
function get_where($pw0,$pwhere,$pfields,$pvalue,$pdelc="")
{   $bs="=";
    if (indexof($pfields,'=')>=0 || indexof($pfields,'>')>=0 || indexof($pfields,'<')>=0) $bs="";
    $pw1=(empty($pwhere)) ? "" : $pfields . $bs . $pdelc . $pvalue . $pdelc;
    $pw0.=((empty($pw0) || empty($pw1))  ? "" : " and ").$pw1 ;
    return $pw0;
}

// LJOIN
function left_join($tabele,$onwhere)
{
    return ' left join '. $tabele .' on '. $onwhere ;
}

// 原来条件，现在条件，属性名，值，前缀名
function get_where_like($pw0,$pwhere,$pfields,$pvalue)
{
    $pw1=(empty($pwhere)) ? "" : $pfields . " like '%" . $pvalue ."%'";
    $pw0.=((empty($pw0) || empty($pw1))  ? "" : " and ").$pw1 ;
    return $pw0;
}

// 原来条件，现在条件，属性名，值，前缀名
function get_like($pw0,$pfields1,$pvalue,$pfields2="")
{   if($pvalue=='undefined') {$pvalue="";}
    if(!empty($pvalue)){
        $pfields1.=empty($pfields2) ? "" : (",".$pfields2);
        $fs= explode(',',$pfields1);

        $pw1="";$aor="";
        for ($i = 0; $i < count($fs); $i = $i + 1) {
            if (!empty( $fs[$i])){
                $pw1.=$aor.  $fs[$i]. " like '%" . $pvalue ."%'";
            }
            $aor=" or ";
        }
        $pw1=empty($pw1) ? "" :" ( ".$pw1." ) ";
        $pw0.=((empty($pw0) || empty($pw1))  ? "" : " and ").$pw1 ;
    }
    return $pw0;
}
// 原来条件，现在条件，属性名，值，前缀名
function get_where_in($pw0,$pwhere,$pfields,$pvalue,$pdelc="")
{
    if($pvalue=='undefined') $pvalue="";
    if($pwhere!=-1&&!empty($pwhere)&&!empty($pvalue)){
        $fs= explode(',',$pvalue);
        $pw1="";$aor="";
        for ($i = 0; $i < count($fs); $i = $i + 1) {
            $pw1.=$aor.  $pfields. "=" . $fs[$i] ;
            $aor=" or ";
        }
        $pw1=empty($pw1) ?"" :" ( ".$pw1." ) ";
        $pw0.=((empty($pw0) || empty($pw1))  ? "" : " and ").$pw1 ;
    }
    return $pw0;
}
//$pvalue=$club;
function get_where_club($pw0,$pfields,$pvalue)
{
    if($pvalue=='undefined') $pvalue="";
    if($pwhere!=-1&&!empty($pwhere)&&!empty($pvalue)){

        $fs= explode(',',$pvalue);
        $pw1="";$aor="";
        for ($i = 0; $i < count($fs); $i = $i + 1) {
            $pw1.=$aor.  $pfields. "=" . $fs[$i] ;
            $aor=" or ";
        }
        $pw1=empty($pw1) ?"" :" ( ".$pw1." ) ";
        $pw0.=((empty($pw0) || empty($pw1))  ? "" : " and ").$pw1 ;
    }
    return $pw0;
}

function get_mess_mobile( $P1 ){
    $P1 =str_replace("00853","853", $P1 );
    return  (substr($P1,0, 3)=="853" ?"" :"853").$P1;
}
function SEND_TEACHER_MESS($PTNO, $PPHONE, $PMSG){
    SEND_MOBILE_MESS("", $PTNO, $PPHONE, $PMSG);
}
function  SEND_STUDENT_MESS($PSTSNUN, $PPHONE, $PMSG ){
    SEND_MOBILE_MESS($PSTSNUN, "", $PPHONE, $PMSG);
}

function SEND_MOBILE_MESS($PsNO, $PTNO, $PPHONE ,$PMSG ){
    $LN = 0;
    while (strlen_hz($PMSG)> 0){
        $LN = strlen_hz($PMSG);
        $LN = ($LN < 70) ?$LN :60;
        SEND_MESS_TO_TABLE($PsNO, $PTNO, $PPHONE,'1002', substr_hz($PMSG, 0,$LN));
        $PMSG = substr_hz($PMSG, $LN + 1);
    }

}

function send_sms_msg($PPHONE,$PMSG){
    SEND_MOBILE_MESS("0000", "0000", $PPHONE, $PMSG);
}

function SEND_MESS_TO_TABLE($PsNO , $PTNO ,$PPHONE, $PTCOD , $PMSG){
    $PPHONE = get_mess_mobile($PPHONE);
    If ((strlen_hz($PPHONE) == 11) &&  is_numeric($PPHONE)) {

        $model = new SmsList();
        $model->isNewRecord = true;
        unset($model->SL_NO);
        $model->SL_DATE =  date('Y-m-d H:i:s');
        $model->SL_SNO = $PsNO;
        $model->SL_TNO = $PTNO;
        $model->SL_PHONE = $PPHONE;
        $model->SL_SENDER = $PTCOD;
        $model->SL_MSG = $PMSG;
        $model->SL_PROCESSED = 'N';
        $model->save();
    }
}

function get_tclass($tclass){
    //$s1=str_replace(substr_hz($tclass,，3),'',substr_hz($tclass,3));
    $s0=subsstr_hz($tclass,0,2);
    $s1=str_replace($s0,'',$tclass);
    $s1=str_replace(')','',$s1);
    $s1=str_replace('(','',$s1);
    return $s1;
}
function rindexof($string,$find,$start=0){
    $pos=strrpos($string,$find,$start);
    if($pos === false) { $pos=-1;}
    return $pos;
}

function gf_implode($separator='|',$parray){
    $rs="";
    if(!empty($parray)){
        $rs=implode($separator,$parray);
    }
    return $rs;
}

function put_msg($pmsg,$parr=0){
    if (is_array($pmsg)){
        //  $pmsg=json_encode($pmsg);
//        $pmsg=json_encode($pmsg,JSON_UNESCAPED_UNICODE);
        $pmsg=CJSON::encode($pmsg);

    }

    // $backtrace = debug_backtrace();
    $test = new Test;
    $test->isNewRecord = true;
    $test->f_msg=$pmsg;
    $test->f_username=Yii::app()->session['TCOD'];
    if ($parr==0){
        $test->f_callname=json_encode(debug_backtrace());
    }
    $test->f_time=get_date();
    $test->save();
}

function get_form_list(){
    return array(
        'id' => 'active-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
                        we.overlay("show");

                        $.ajax({
                            type:"post",
                            url:form.attr("action"),
                            data:form.serialize()+"&submitType="+submitType,
                            dataType:"json",
                            success:function(d){
                                if(d.status==1){
                                    we.success(d.msg, d.redirect);
                                }else{
                                    we.error(d.msg, d.redirect);
                                }
                            }
                        });
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
        ),
    );
}

function get_form_login(){
    return array(
        'id' => 'active-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
                    
                }',
        ),
    );
}


function show_shenhe_box($she_box_name,$mname= "", $ac= "") {
    // $mname= ""; $ac= "";
    $cmd=0;

    $s1="";
    foreach ($she_box_name as $bname => $btitle) {
        $s0=substr($bname,0,1);
        if(is_numeric($s0)){
            $bname=substr($bname,1);
            $cmd=1;
        }
        $oname=$bname;
        $oname1=$bname;
        if($oname=='tongguo'){$oname1='shenhe';}
        if($oname=='butongguo'){$oname1='shenhe';}
        if($oname=='tuihui'){$oname1='shenhe';}//退回修改
        if($oname=='quxiao'){$oname1='shenhe';}  // quxiao:取消审核
        if($oname=='chexiao'){$oname1='revoke';}  // 1、revoke=撤销提交  2、next=下一步
        if(($oname=='baocun') || ($oname=='shenhe') || ($oname=='next')){$oname='update';$oname1='create';}

        $s1.='<button id="'.$bname.'" onclick="submitType='."'".$bname."'".'"';
        $s1.=' class="btn btn-blue" type="submit"> '.$btitle.'</button>&nbsp;';

    }
    //  $s1=check_data_quren($s1);
    return $s1;
}

// $is_s2为自定义属性功能
function show_command($command,$url="",$title="",$style='',$is_s2='') {
    $s1=substr($command,0,1);
    $cmd=0;
    if(is_numeric($s1)){
        $command=substr($command,1);
        $cmd=1;
    }
    $s1= "";$s2= "delete";
    if ($command == '添加') {
        $s1='<a class="btn" href="'.$url.'" '.$style.'>';
        $s1.='<i class="fa fa-plus"></i>'.$title.'</a>';
        $s2='create';
    } else if ($command == '编辑') {
        $s1='<a class="btn" href="'.$url.'" title="'.'编辑'.'"> ';
        $s1.=empty($title) ? '<i class="fa fa-edit"></i></a>' : $title.$style.'>'.$title.'</a>';
        $s2='update';
    }
    else if ($command == '申请代领') {
        $s1='<a class="btn" href="'.$url.'" title="'.'申请代领'.'"> ';
        $s1.=empty($title) ? '<i class="fa fa-plus-square"></i></a>' : $title.$style.'>'.$title.'</a>';
        $s2='update';
    }
    else if ($command == '详情') {
        $s1='<a class="btn" href="'.$url.'" title="'.$command.'"> ';
        $s1.=empty($title) ? '<i class="fa fa-edit"></i></a>' : $title.$style.'>'.$title.'</a>';
        $s2='update';
    }
    else if ($command == '批删除') {
        $s1='<a style="display:none;" id="j-delete" class="btn"';
        $s1.=' href="javascript:;" onclick="';
        $s1.="we.dele(we.checkval('.check-item input:checked'), deleteUrl)";
        $s1.=';"><i class="fa fa-trash-o"></i>'.$title.'</a>';
    }
    else if ($command == '批上架') {
        $s1='<a style="display:none;" id="j-delete" class="btn"';
        $s1.=' href="javascript:;" onclick="';
        $s1.="putout(we.checkval('.check-item input:checked'), putoutUrl);we.reload();";
        $s1.=';"><i class="fa fa-plus-square"></i>'.$title.'</a>';
    }else if ($command == '删除') {
        $s1='<a class="btn" href="javascript:;" onclick="we.dele(';
        $s1.=$url.', deleteUrl);" title="删除">';
        $s1.=empty($title) ? '<i class="fa fa-trash-o"></i></a>' : $title.'</a>';
    }
    else{
        $s1='<a class="btn" href="'.$url.'" '.$style.' title="'.$title.'">'.$title.'</a>';
        $s2=$is_s2;
    }

    $s1=check_power($s1,$command);
    return $s1;
}

function check_power($s1,$command)
{
    if(Yii::app()->session['F_ROLENAME']!='系统管理员'){
        if($command=='添加' and $_SESSION['views']!='快递录入' ){
            $s1='';
        }
        if($command=='删除'||$command=='批删除') $s1='';

    }



    return $s1;
}

function toIoArray($cooperation,$afieldstr,$def_array=array())
{
    $arr=array();
    if($def_array) $arr[] = $def_array;
    $r=0;
    $afieldstmp=explode(',',$afieldstr);
    foreach($afieldstmp as $v1){
        $a=explode(':',$v1);
        $afields[$a[0]]=$a[0];
        if(isset($a[1])) $afields[$a[0]] = $a[1];//有别名
    }
    if(is_array($cooperation))
        foreach ($cooperation as $v) {
            $ta=array();
            foreach($afields as $k=>$v1){
                if($k){
                    $vs=$v[$k];
                    if(empty($vs)) $vs="";
                    $ta[$v1] = $vs;
                }
            }
            $r=$r+1;

            $arr[]=$ta;
        }
    return $arr;
}

function toArrayNoname($cooperation,$afieldstr)
{
    $arr=array();
    $r=0;
    $afieldstmp=explode(',',$afieldstr);
    if(is_array($cooperation))
        foreach ($cooperation as $v) {
            $arr[]=$v[$afieldstr];
        }
    return $arr;
}

function save_change($table,$uptype,$data,$keyname,$keyvalue) {
    if($table=='user')return;
    if (is_array($data)){
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    $test=new Datachange();
    $test->isNewRecord = true;
    $test->f_field=$keyname;
    $test->f_value=$keyvalue;
    $test->f_data=$data;
    $test->f_table=$table;
    $test->f_update=$uptype;
    $test->f_user=Yii::app()->session['TCOD'];
    $test->f_tname=Yii::app()->session['TNAME'];
    $test->f_time=date('Y-m-d H:i:s');
    $test->save();
}

function save_change_table($table) {
    $tmp=Datachangetable::model()->find("f_table='".$table."'");
    if(empty($tmp)){
        $test=new Datachangetable();
        $test->isNewRecord = true;
        $test->f_table=$table;
        $test->save();
    }
}



//传入图片地址，id名（update用）
function show_pic($flie='',$id='',$maxHeight='80',$maxWidth='70'){
    $html='';
    if($flie){
        $html=empty($id)?'<div style="max-width:'.$maxHeight.'px; max-height:'.$maxWidth.'px;overflow:hidden;">':
            '<div style="float: left; margin-right:10px" id="upload_pic_'.$id.'">';
        $html.= '<a href="'.$flie.'" target="_blank" title="点击查看">';
        $html.= substr($flie,-3,3)=='pdf'?
            '<img src="'.'/scnursps/uploads/temp/image/pdf_icon.jpg'.'" style="max-height:30px; max-width:20px;">':
            '<img src="'.$flie.'" style="max-height:'.$maxHeight.'px; max-width:'.$maxWidth.'px;">';
        $html.='</a></div>';
    }
    return $html;
}

function show_picture($flie='',$id=''){
    $html='';
    if($flie){
        $html=empty($id)?'<div style="max-width:150px; max-height:80px;overflow:hidden;">':
            '<div style="float: left; margin-right:50px" id="upload_pic_'.$id.'">';
        $html.= '<a href="'.$flie.'" target="_blank" title="点击查看">';
        $html.= substr($flie,-3,3)=='pdf'?
            '<img src="'.'/scnursps/uploads/temp/image/pdf_icon.jpg'.'" style="height:80px; width:150px;">':
            '<img src="'.$flie.'" style="height:80px; width:150px;">';
        $html.='</a></div>';
    }
    return $html;
}


function fget_fieldstr($model) {
    $dm= $model::model()->attributeLabels();
    $s1='';$b1='';
    foreach($dm as $k=>$v)
    {
        $s1.=$b1.$k.':'.$k; //'模型字段:返回字段名'
        //$s1.=$b1.$k;
        $b1=',';
    }
    return $s1;
}



function getParameter($def_value='') {
    $request = file_get_contents('php://input');
    $rs=json_decode($request,true);
    $arr1 =explode(',',$def_value);
    if(is_array($arr1))
        foreach ($arr1 as $v) {
            $ds=explode(':',$v);
            if(!isset($rs[$ds[0]]))
            {$rs[$ds[0]]='';}
            if(isset($ds[1])){
                if(empty($rs[$ds[0]]))
                    $rs[$ds[0]]=$ds[1];
            }
        }
    $openid=getOpenid();
    $rs['openid']=$openid;
    if(!isset($rs['userId'])) $rs['userId']='';
    if(empty($rs['userId']) &&($openid)){
        $tmp=User::model()->find("wx_openid='".$openid."'");
        if($tmp){
            $rs['userId']=$tmp->userId;
        }
    }
    return $rs;
}


function getOpenid(){
    //获取函数头的token
    if(!isset($_SERVER['HTTP_TOKEN'])) return '';
    $token=$_SERVER['HTTP_TOKEN'];
    Yii::$enableIncludePath = false;
    Yii::import('application.extensions.JWT', 1);
    $jwt=new Jwt;
    //对token进行解码
    $getPayload=$jwt->verifyToken($token);
    return $getPayload['openid'];
}


function DecodeAsk($var,$default='0'){
    return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
}

/**
 *   生成某个范围内的随机时间
 * @param <type> $begintime  起始时间 格式为 Y-m-d H:i:s
 * @param <type> $endtime    结束时间 格式为 Y-m-d H:i:s
 */
function randomDate($begintime, $endtime="") {
    $begin = strtotime($begintime);
    $end = $endtime == "" ? mktime() : strtotime($endtime);
    $timestamp = rand($begin, $end);
    return date("Y-m-d H:i:s", $timestamp);
}

function LogInfo($tmp,$out='',$in='',$sys='',$is_answer='0'){
  $log=new InfoLog();
  $log->in_id=($in=='')?$tmp->in_id:$in;
  $log->out_id=($out=='')?$tmp->out_id:$out;
  $log->package_id=$tmp->package_id;
  $log->p_name=$tmp->p_name;
  $log->state=$tmp->state;
  $log->apply_time=$tmp->apply_time;
  $log->answer_time=$tmp->answer_time;
  $log->type=$tmp->type;
  $log->out_name=($out=='')?$tmp->out_name:$tmp->in_name;
  $log->in_name=($in=='')?$tmp->in_name:$tmp->out_name;
  $log->out_remark=$tmp->out_remark;
  $log->in_remark=0;
  $log->out_state=$tmp->out_state;
  $log->in_state=$tmp->in_state;
  $log->sys_msg=($sys=='')?$tmp->sys_msg:$sys;
  $log->is_answer=$is_answer;
  $log->apply_id=$tmp->id;
  $log->c_id=$tmp->c_id;
  $log->save();
}


function UpdateLog($tmp){
    $arr=InfoLog::model()->findAll('apply_id='.$tmp->id);
   foreach ($arr as $log){
       $log->state=$tmp->state;
       $log->apply_time=$tmp->apply_time;
       $log->answer_time=$tmp->answer_time;
       $log->out_remark=$tmp->out_remark;
       $log->in_remark=0;
       $log->out_state=$tmp->out_state;
       $log->in_state=$tmp->in_state;
       if($log->state==3)$log->sys_msg='消息已经过期';
       $log->save();
   }

}


function getf_url($_thisController){
    return lcfirst($_thisController->getId()).'/'. $_thisController->getAction()->getId();
}

function show_title($_thisController,$subtile=''){
    $style1='';
    $blue='color:DodgerBlue';
    if(empty($subtile)){
        $url=getf_url($_thisController);
        setcookie('f_url',$url);
        $style1=$blue;
    }else{
        $url=get_cookie('f_url');
    }
    $meun=Menu::model()->find("f_url="."'$url'");
    $group=$meun->f_group;
    $name=$meun->f_name;

    $str= '<div class="box-title c">'.
        '<h2><i class="fa fa-table"></i>'. ' 当前界面：'.$group.'》'.
        '<span style="'.$style1.'">'.  $name.'</span>';

    if(!empty($subtile)){
        $str.='》'.'<span style="'.$blue.'">'.$subtile.'</span>';
        $str.='<span class="back"><a2 class="btn" href="javascript:;" onclick="we.back();"> <class="fa fa-reply"></i>'.
            '返回'. '</a2></span>';
    }

    $str.='</h2>' .'</div>';

    return $str;
}






<?php
    function hq_appID()//获取appID 
    {
	if(file_exists("config.ini")) {
		$str = file_get_contents("config.ini");
		$arr = json_decode($str, true);
		return $arr["appID"];
	}
}
function hq_appsecret()//获取appsecret 
{
	if(file_exists("config.ini")) {
		$str = file_get_contents("config.ini");
		$arr = json_decode($str, true);
		return $arr["appsecret"];
	}
}
function hq_userid()//获取userid 
{
	if(file_exists("config.ini")) {
		$str = file_get_contents("config.ini");
		$arr = json_decode($str, true);
		return $arr["userid"];
	}
}
function hq_template_id()//获取template_id 
{
	if(file_exists("config.ini")) {
		$str = file_get_contents("config.ini");
		$arr = json_decode($str, true);
		return $arr["template_id"];
	}
}
function hq_access_token()//获取access_token 
{
	if(file_exists("config.ini")) {
		$str = file_get_contents("config.ini");
		$arr = json_decode($str, true);
		return $arr["access_token"];
	}
}
function gx_access_token()//更新access_token 
{
	$html = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".hq_appID()."&secret=".hq_appsecret());
	$arr = json_decode($html, true);
	$json_string = file_get_contents("config.ini");
	// 从文件中读取数据到PHP变量
	$data = json_decode($json_string,true);
	// 把JSON字符串转成PHP数组
	$data["access_token"]=$arr["access_token"];
	;
	$json_strings = json_encode($data);
	file_put_contents("config.ini",$json_strings);
	//写入
	return $arr["access_token"];
}
function fs_message($title,$content,$url,$now_date)//发送信息 
{
	$html=file_get_contents('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.hq_access_token(), false, stream_context_create(array('http' => array('method'=>'post','header'=>"Content-Type: application/json;charset=utf-8",'content'=>'{"touser":"'.hq_userid().'","template_id":"'.hq_template_id().'","url":"'.$url.'","topcolor": "#FF0000","data":{"title":{"value":"'.$title."  ".$now_date.'","color":"#000851"},"content":{"value":"'.$content.'","color":"#1CB5E0"}}}'))));
	$arr = json_decode($html, true);
	//echo $html;
	//echo $arr["errcode"];
	if ($arr["errcode"]>0) {
		//access_token超时
		gx_access_token();
		$html=file_get_contents('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.hq_access_token(), false, stream_context_create(array('http' => array('method'=>'post','header'=>"Content-Type: application/json;charset=utf-8",'content'=>'{"touser":"'.hq_userid().'","template_id":"'.hq_template_id().'","url":"'.$url.'","topcolor": "#FF0000","data":{"title":{"value":"'.$title."  ".$now_date.'","color":"#000851"},"content":{"value":"'.$content.'","color":"#1CB5E0"}}}'))));
		$arr = json_decode($html, true);
		//echo $arr["errcode"];
		//echo "gx".$html;
		return $html;
	}
	return $html;
}
function tj_sql($title,$content,$now_date) {
	//生成随机文件名
	$hash=date("Y").date("m").date("d")."-";
	if(is_array($_GET)&&count($_GET)>0)//判断是否有Get参数 
	{
		if(isset($_GET["hash"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false 
		{
			$hash=$_GET["hash"];
			//存在 
			if($hash==null) {
				$hash=date("Y").date("m").date("d")."-";
			}
		}
	}
	//定义一个包含大小写字母数字的字符串
	$chars="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	//把字符串分割成数组
	$newchars=str_split($chars);
	//打乱数组
	shuffle($newchars);
	//从数组中随机取出16个字符
	$chars_key=array_rand($newchars,16);
	//把取出的字符重新组成字符串
	for ($i=0;$i<15;$i++) {
		$fnstr.=$newchars[$chars_key[$i]];
	}
	//输出文件名并做MD5加密
	$hash=$hash.md5($fnstr.time().microtime()*1000000);
	if(file_exists("config.ini")) {
		$str = file_get_contents("config.ini");
		$arr = json_decode($str, true);
		$servername =  $arr["servername"];
		$username = $arr["username"];
		$password = $arr["password"];
		$dbname = $arr["dbname"];
		$web = $arr["web"];
	}
	// 创建连接
	$conn = new mysqli($servername, $username, $password, $dbname);
	// 检测连接
	if ($conn->connect_error) {
		die("连接失败: " . $conn->connect_error);
	}
	
	$sql = "INSERT INTO `data` (`id`, `url`, `title`, `content`, `time`) VALUES (NULL, "."'".$hash."', '".$title."', '".$content."', '".$now_date."');";
	if ($conn->query($sql) === TRUE) {
		//echo "新记录插入成功";
	} else {
		//echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
	echo '<div align="center"> <a href='.$web."index.php?key=".$hash.'>通知页面</a></div>' ;
	
	
	return $web.'index.php?key='.$hash;
}
if(is_array($_GET)&&count($_GET)>0)//判断是否有Get参数 
{
	if(isset($_GET["content"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false 
	{
		$title=$_GET["title"];
		$content=$_GET["content"];
		$now_time= time();
        $now_date= date('Y年m月d日 H:i:s',$now_time);
		//echo $title.$content;
		fs_message($title,$content,tj_sql($title,$content,$now_date),$now_date);
	}
}
?>
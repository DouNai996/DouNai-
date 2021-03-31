<?php
if(is_array($_GET)&&count($_GET)>0)//判断是否有Get参数 
{
	if(isset($_GET["key"]))//判断所需要的参数是否存在，isset用来检测变量是否设置，返回true or false 
	{
		$key=$_GET["key"];
		if(file_exists("config.ini")) {
			$str = file_get_contents("config.ini");
			$arr = json_decode($str, true);
			$servername =  $arr["servername"];
			$username = $arr["username"];
			$password = $arr["password"];
			$dbname = $arr["dbname"];
		}
		// 创建连接
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("连接失败: " . $conn->connect_error);
		}
		$sql = "SELECT * FROM `data` WHERE `url` = '".$key."'";
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			// 输出数据
			while($row = $result->fetch_assoc()) {
				$title=$row["title"];
				$content=$row["content"];
			}
		} else {
			$title="404";
			$content="你所访问的网址可能有问题";
		}
		$conn->close();
		$txt=file_get_contents('mb.html');
		$txt=str_replace('@@@@@',$title,$txt);
		$txt=str_replace('#####',$content,$txt);
		//可以类似的语句替换许多变量
		echo $txt;
	}
}
?>
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
				$time = " 时间：".$row["time"];
			}
		} else {
			$title="404";
			$content="你所访问的网址可能有问题";
			
		}
		$conn->close();
		$txt="<html lang="."en"."><head><style>.container{padding:10px;box-sizing:border-box;width:100%;height:100%}.close{}.img-close{width:20px;height:20px}.title{font-size:22px;font-weight:400;color:#333;line-height:33px;margin:0px 0 10px 0}.date{font-size:15px;font-weight:500;color:#999;line-height:15px;margin-bottom:30px}.cont-wrap{white-space:normal;word-break:break-all;word-wrap:break-word;padding:0px;border-radius:10px;border:2px dashed#ccc}.cont{font-size:16px;font-weight:500;color:#666;line-height:30px;padding:10px}.span{color:#000}.label{background-color:rgb(45,183,245);color:#1890ff;background:#e6f7ff;border-color:#91d5ff;margin-right:8px;padding:0 7px}.messageType{color:#1890ff;background:#e6f7ff}.auth{font-size:15px;font-weight:bold;color:#000000}h4{margin:0px;padding:0px}hr{border-style:solid;border-width:1px 0px 0px;border-color:rgba(0,0,0,0.1);transform-origin:0px 0px;transform:scale(1,0.5)}.td{margin:15px 0 0 0;text-align:center;display:none}</style><title>".$title."</title></head><body><div class="."container"."><div class="."title".">".$title."</div><div class="."date"."><span class="."auth".">豆奶酱</span><span>".$time."</span></div><div class="."cont-wrap"."><div class="."cont".">".$content."</div></div></body></html>";
		echo $txt;
	}
}
?>

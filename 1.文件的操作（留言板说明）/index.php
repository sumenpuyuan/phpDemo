<html>
<head>
	<title>留言板</title>
</head>
<body>
	<?php
		$filename="text_data.txt";
		if(isset($_POST["sub"])){
			$message=$_POST['username']."||".$_POST['title']."||".$_POST['mess']."<|>";
			writeMessage($filename,$message);
		}
		if(file_exists($filename)){
			readMessage($filename);
		}
		//写入文件函数
		function writeMessage($filename,$message){
			$fp=fopen($filename,"a");//以追加的方式打开文件
			if(flock($fp,LOCK_EX)){
				//独占锁定，向文件写入数据时使用
				fwrite($fp, $message);
				flock($fp, LOCK_UN);//释放锁定
			}else{
				echo "不能锁定文件";
			}
			fclose($fp);
		}
		//遍历读取文件的函数
		function readMessage($filename){
			$fp=fopen($filename,"r");//以只读的模式打开
			flock($fp,LOCK_SH);//建立共享锁定，从文件读取数据时使用
			$buffer="";
			while(!feof($fp)){
				$buffer.=fread($fp,1024);
			}
			$data=explode("<|>",$buffer);
			var_dump($data);
			foreach ($data as $line) {
				$temp=explode("||",$line);
				if(count($temp) == 1);
				else{
					//echo count($temp);
				list($username,$title,$message)=$temp;
				if($username != ""&& $title!="" && $message!=""){
					echo $username."说";
					echo $title;
					echo $message."<br/>";
				}
				}
				
			}
			flock($fp,LOCK_UN);
			fclose($fp);
		}

	?>
	<form action="" method="post">
		<input type="text" size=10 name="username" placeholder="用户名"/><br/>
		<input type="text" size=30 name="title" placeholder="标题"/><br/>
		<textarea name="mess" rows=4 cols=38>请在这里输入留言信息</textarea>
		<input type="submit" name="sub" value="留言"/>
	</form>
</body>
</html>
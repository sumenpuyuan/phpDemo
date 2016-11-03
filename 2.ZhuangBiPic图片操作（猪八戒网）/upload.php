<?php
	
	$allowtype=array("jpg");
	$size=1000000;
	//判断文件是否可以成功上传到服务器$_FILE['myfile'['error']]为0代表上传成功
	if($_FILES['myfile']['error']){
		//header("Location:index.php?error=1");
	}
	//echo $_FILES['myfile']['name'];
	//判断上传的文件是否为允许的文件类型 通过文件后缀名
	$test=explode(".",$_FILES['myfile']['name']);
	$hz=array_pop($test);
	//通过判断文件后准 判断是否允许上传、
	if(!in_array($hz, $allowtype)){
		//header("Location:index.php?error=3");
	}
	if($_FILES['myfile']['size'] > $size){
		//header("Location:index.php?error=2");
	}
	//上传文件
	move_uploaded_file($_FILES['myfile']['tmp_name'], $_FILES['myfile']['name']);

	$name=$_POST['name'];
	$company=$_POST['company'];
	$filename=$_FILES['myfile']['name'];
	$id=getRandChar(10);
	//echo $name;
	$arr=arr_split_zh($name);
	//var_dump($arr);
	//echo $arr[0];
	//$filename是头像图片名字
	//这是缩放的操作
		$width=100;
		$height=140;
		list($width_org,$height_org)=getimagesize($filename);
		$image_p=imagecreatetruecolor($width, $height);
		$image=imagecreatefromjpeg($filename);
		$back=imagecreatefromjpeg("lvxuejie.jpg");
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_org, $height_org);
		imagecopy($back, $image_p, 519, 111, 0, 0, 100, 140);

		//这里是写公司单位的代码
		$cor = imagecolorallocate($back, 0, 0, 0);
		$font = 'xihei.ttf';
		$a = im($back, 12, 0, 600, 300, $cor, $font, $company,3);
		//身份证号代码
		$cor = imagecolorallocate($back, 0, 0, 0);
		$a = im($back, 12, 0, 686, 165, $cor, $font, $id,3);
		//姓名代码
		

		for($i=0;$i<count($arr);$i++){
			$cor = imagecolorallocate($back, 0, 0, 0);
			$a = im($back, 12, 30, 680+$i*100*0.154, 132-$i*20*0.5, $cor, $font, $arr[$i],3);
		}
		//姓名要进行斜体操作
		unlink($filename);
		header('Content-type:image/jpeg');
		imagejpeg($back);
		//unlink($filename);


		function im(&$image, $size, $angle, $start_x, $y, $color, $font, $text,$spancing) {
			for ($i=0;$i<mb_strlen($text,'utf8');$i++) {
			    $t = mb_substr($text, $i,1,'utf8');
			    $x = $i*($size+$spancing);
			    imagettftext($image, $size, $angle, $x+$start_x, $y, $color, $font, $t);
			    }  
		}
		//生成随机字符串
		function getRandChar($length){
		   $str = null;
		   $strPol = "0123456789";
		   $max = strlen($strPol)-1;
		   for($i=0;$i<$length;$i++){
		    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
		   }
		   return $str;
		}
	function arr_split_zh($tempaddtext){
   $tempaddtext = iconv("UTF-8", "gb2312", $tempaddtext);
    $cind = 0;
    $arr_cont=array();

    for($i=0;$i<strlen($tempaddtext);$i++)
    {
        if(strlen(substr($tempaddtext,$cind,1)) > 0){
        	if(ord(substr($tempaddtext,$cind,1)) < 0xA1 ){ //如果为英文则取1个字节
                array_push($arr_cont,substr($tempaddtext,$cind,1));
                $cind++;
            }else{
                array_push($arr_cont,substr($tempaddtext,$cind,2));
                $cind+=2;
            }
        }
    }
   foreach ($arr_cont as &$row)
   {
   	$row=iconv("gb2312","UTF-8",$row);
   }

return $arr_cont;

}
?>

<html>
<head>
	<meta charset="utf-8"/>
	<style>
			.ui-header-positive, .ui-footer-positive {
			background-color: #f05557;
			color: #fff;
		}
	</style>
</head>
<body>
	<header class="ui-header ui-header-positive ui-border-b">
	<h1>长按下方图片点选保存图片</h1>
	</header>
<body>
<?php

	$allowtype=array("jpg");
	$size=1000000;
	//判断文件是否可以成功上传到服务器$_FILE['myfile'['error']]为0代表上传成功
	if($_FILES['myfile']['error']){
		header("Location:index.php?error=1");
	}
	//echo $_FILES['myfile']['name'];
	//判断上传的文件是否为允许的文件类型 通过文件后缀名
	$test=explode(".",$_FILES['myfile']['name']);
	$hz=array_pop($test);
	//通过判断文件后准 判断是否允许上传、
	if(!in_array($hz, $allowtype)){
		header("Location:index.php?error=3");
	}
	if($_FILES['myfile']['size'] > $size){
		header("Location:index.php?error=2");
	}
	//上传文件
	move_uploaded_file($_FILES['myfile']['tmp_name'], $_FILES['myfile']['name']);

	$name=$_POST['name'];
	$company=$_POST['company'];
	$filename=$_FILES['myfile']['name'];

	thumb($_FILES['myfile']['name'],100,140);
	watermark("lvxuejie.jpg",$_FILES['myfile']['name']);
	$id=getRandChar(10);
	//echo strlen($name);
	//获得用户输入姓名的各个字符
	$arr=str_to_arr($name);
	echo count($arr);
	//Xiezi($name,680,132);
	Xiezi($company,600,300);
	Xiezi($id,686,165);
	//删除上传的文件，防止服务器堆积太多图片文件
	unlink($filename);
	//写字函数
	//680 132
	function Xiezi($tt,$width,$height){
		$image = ImageCreateFromJPEG( "test.jpg" );
		$cor = imagecolorallocate($image, 0, 0, 0);
		$font = 'xihei.ttf';
		//$tt = '我们的灵魂';
		//imagepsslantfont($font, 22.5);
		$a = im($image, 12, 0, $width, $height, $cor, $font, $tt,3);
		//header('Content-type: image/jpeg');
		imagejpeg($image,"test.jpg");
	}
	function im(&$image, $size, $angle, $start_x, $y, $color, $font, $text,$spancing) {
		 
		for ($i=0;$i<mb_strlen($text,'utf8');$i++) {
		    $t = mb_substr($text, $i,1,'utf8');
		    $x = $i*($size+$spancing);
		    imagettftext($image, $size, $angle, $x+$start_x, $y, $color, $font, $t);
		    }  
		 
		}

	//图片缩放
	function thumb($filename,$width=200,$height=200){
		list($width_org,$height_org)=getimagesize($filename);
		/*if($width && ($width_org < $height_org)){
			$width=($height/$height_org)*$width_org;
		}
		else{
			$height=($width/$width_org)*$height_org;
		}*/
		//如果上面代码没被注释 那么是等比例缩放
		$image_p=imagecreatetruecolor($width, $height);
		$image=imagecreatefromjpeg($filename);
		imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_org, $height_org);
		imagejpeg($image_p,$filename,100);

		imagedestroy($image_p);
		imagedestroy($image);
	}
	//加水印的函数
	function watermark($filename,$water){
		list($b_w,$b_h)=getimagesize($filename);
		list($w_w,$w_h)=getimagesize($water);
		$posX=rand(0,($b_w-$w_w));
		$posY=rand(0,($b_h-$b_h));
		$back=imagecreatefromjpeg($filename);
		$water=imagecreatefromjpeg($water);
		imagecopy($back, $water, 519, 111, 0, 0, $w_w, $w_h);
		imagejpeg($back,"test.jpg");
		imagedestroy($back);
		imagedestroy($water);
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

	
	//逐字拆分函数
	function str_to_arr($str){  
		$l=strlen($str);  
		for($i=0;$i<$l;$i++){   
			$arr[]=ord($str[$i])>127?$str[$i].$str[++$i]:$str[$i];  
		}  
		return $arr; 
	}
	
?>
<center>
<img src="test.jpg" />
</center>
</html>

<html>
<head>
	<title>文件上传</title>
	<style type="text/css">  
		#preview, .img, img  
		{  
		 	width:640px;  
		 	height:480px;  
		 	margin:40px auto;
		}  
		#preview  
		{  
			border:1px solid #000;  
		}  
		.ui-header-positive, .ui-footer-positive {
			background-color: #f05557;
			color: #fff;
		}
		a {
			color: #f05557;
		}
	 </style>  
</head>
<body>
	<header class="ui-header ui-header-positive ui-border-b">
	<h1>保时捷918选配单生成器</h1>
</header>
	<div id="preview"></div>  
	<form action="upload.php" method="post" enctype="multipart/form-data" name="formen">
		<input type="text" name="name">姓<br>
		<input type="text" name="company">公司<br>
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
		<input type="file"   name="myfile" style="visibility:hidden" onchange="preview(this)" id="picpath">

	
		<input type="button" value="选择图片" onclick="document.formen.picpath.click()"/>
		<input type="submit" value="上传文件">
	</form>
<script type="text/javascript">    
	 function preview(file)  
	 {  
		 var prevDiv = document.getElementById('preview');  
		 if (file.files && file.files[0])  
		 {  
			 var reader = new FileReader();  
			 reader.onload = function(evt){  
			 	prevDiv.innerHTML = '<img src="' + evt.target.result + '" />';  
			}    
		 	reader.readAsDataURL(file.files[0]);  
		}  
		else    
		{  
			prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';  
		}  
	 }  
 </script>  


	<?php	
	if(!empty($_GET['error'])){
		$error=$_GET['error'];
		if($error==1){
			echo "<script>alert('大小超出php配置文件大小')</script>";
		}
		else if($error == 2){
			echo "<script>alert('超出表单的约束值')</script>";
		}else if($error == 3){
			echo "<script>alert('不支持的格式，请传jpg格式')</script>";
		}else
		{
			echo "<script>alert('未知错误')</script>";
		}
	}?>

</body>
</html>
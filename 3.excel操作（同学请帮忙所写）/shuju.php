<?php
	/** Include PHPExcel_IOFactory */
	require_once 'Classes/PHPExcel/IOFactory.php';
	require_once 'Classes/PHPExcel.php';

	
	/*下面的是读取源数据*/
	$filePath = "origin.xlsx";
	//建立reader对象
		$PHPReader = new PHPExcel_Reader_Excel2007();
		if(!$PHPReader->canRead($filePath)){
			$PHPReader = new PHPExcel_Reader_Excel5();
			if(!$PHPReader->canRead($filePath)){
				echo 'no Excel';
				return ;
			}
		}
		//建立excel对象，此时你即可以通过excel对象读取文件，也可以通过它写入文件
		$PHPExcel = $PHPReader->load($filePath);
		/**读取excel文件中的第一个工作表*/
		$currentSheet = $PHPExcel->getSheet(0);
	/*读取文件结束*/
	
	if (!file_exists("3.xlsx")) {
		exit("Please run 05featuredemo.php first." . EOL);
	}
	
	$objPHPExcel = PHPExcel_IOFactory::load("3.xlsx");
	$objPHPExcel->setActiveSheetIndex(0);
	$char=array('C','D','E','F','G','H');
	$colIndex='A';
	$rowIndex=3;
	//最外层控制行
	for($ik=2;$ik<=1251;$ik++)
	{
		//这里循环取出源数据
		$add=$colIndex.($ik+1);
		$cell=$currentSheet->getCell($add)->getValue();
		if($cell instanceof PHPExcel_RichText)     //富文本转换字符串
            $cell = $cell->__toString();
		$new=explode(",",$cell);
        $new[0]=substr($new[0],19);
        for($ij=0;$ij<6;$ij++){
            $new[$ij]=trim($new[$ij]);
        }
		var_dump($new);
		for($i=0;$i<6;$i++){
			//处理元数据开始
			//$add='A'.3;
			$address=$char[$i].$ik;
			$objPHPExcel->getActiveSheet()->setCellValue($address, $new[$i]);
		}
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$ik, Number);
	}
		
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("2.xlsx");



	

?>
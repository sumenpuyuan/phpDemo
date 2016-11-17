<?php
	/** Include PHPExcel_IOFactory */
	require_once 'Classes/PHPExcel/IOFactory.php';
	require_once 'Classes/PHPExcel.php';

	
	/*������Ƕ�ȡԴ����*/
	$filePath = "origin.xlsx";
	//����reader����
		$PHPReader = new PHPExcel_Reader_Excel2007();
		if(!$PHPReader->canRead($filePath)){
			$PHPReader = new PHPExcel_Reader_Excel5();
			if(!$PHPReader->canRead($filePath)){
				echo 'no Excel';
				return ;
			}
		}
		//����excel���󣬴�ʱ�㼴����ͨ��excel�����ȡ�ļ���Ҳ����ͨ����д���ļ�
		$PHPExcel = $PHPReader->load($filePath);
		/**��ȡexcel�ļ��еĵ�һ��������*/
		$currentSheet = $PHPExcel->getSheet(0);
	/*��ȡ�ļ�����*/
	
	if (!file_exists("3.xlsx")) {
		exit("Please run 05featuredemo.php first." . EOL);
	}
	
	$objPHPExcel = PHPExcel_IOFactory::load("3.xlsx");
	$objPHPExcel->setActiveSheetIndex(0);
	$char=array('C','D','E','F','G','H');
	$colIndex='A';
	$rowIndex=3;
	//����������
	for($ik=2;$ik<=1251;$ik++)
	{
		//����ѭ��ȡ��Դ����
		$add=$colIndex.($ik+1);
		$cell=$currentSheet->getCell($add)->getValue();
		if($cell instanceof PHPExcel_RichText)     //���ı�ת���ַ���
            $cell = $cell->__toString();
		$new=explode(",",$cell);
        $new[0]=substr($new[0],19);
        for($ij=0;$ij<6;$ij++){
            $new[$ij]=trim($new[$ij]);
        }
		var_dump($new);
		for($i=0;$i<6;$i++){
			//����Ԫ���ݿ�ʼ
			//$add='A'.3;
			$address=$char[$i].$ik;
			$objPHPExcel->getActiveSheet()->setCellValue($address, $new[$i]);
		}
		$objPHPExcel->getActiveSheet()->setCellValue('I'.$ik, Number);
	}
		
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("2.xlsx");



	

?>
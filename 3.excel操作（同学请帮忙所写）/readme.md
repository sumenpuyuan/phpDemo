# 文件介绍 #
shuju.php主文件

orgin。xlsx源文件，

3.xlsx最初的要保存的文件

2.xlsx已经做完处理的要保存的文件
<h2>
    （-）起因
</h2>
<p>
    同洋同学找到我说要帮她个excel的忙，本以为很简单，谁知。。。。
</p>
<p>
    具体要求是：把一个excel文档里的东西粘贴到另一个excel里面，以为只是粘贴复制就行了。谁知，，你的原始excel的数据都是在一个单元格里存着的，就是下面这样。
</p>
<table width="172">
    <colgroup>
        <col width="172" style=";width:172px"/>
    </colgroup>
    <tbody>
        <tr class="firstRow"></tr>
    </tbody>
</table>
<h3>
    <strong>A1：</strong>
</h3>
<p>
    10/14/2016 &nbsp; 20:02:28&nbsp;&nbsp;&nbsp; 46.53,&nbsp;&nbsp;&nbsp; 7.71,&nbsp;&nbsp;&nbsp; &nbsp; 6.32,&nbsp;&nbsp; 33.07,&nbsp;&nbsp;&nbsp; 1.22,&nbsp;&nbsp;&nbsp; &nbsp; 0.53,&nbsp;&nbsp; 7,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0,&nbsp;&nbsp;&nbsp; 1372,&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; 143 &nbsp; &nbsp;
</p>
<h3>
    A2：
</h3>
<p>
    10/14/2016 20:03:15&nbsp;&nbsp;&nbsp; 53.60,&nbsp;&nbsp;&nbsp; &nbsp; 8.81,&nbsp;&nbsp;&nbsp; 6.37,&nbsp;&nbsp; 34.84,&nbsp;&nbsp;&nbsp; &nbsp; 1.38,&nbsp;&nbsp;&nbsp; 0.55,&nbsp;&nbsp; 7,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1372,&nbsp;&nbsp;&nbsp; 1476,&nbsp;&nbsp;&nbsp;&nbsp; &nbsp; 158 &nbsp; &nbsp;
</p>
<h3>
    A3：
</h3>
<p>
    10/20/2016 21:01:18&nbsp;&nbsp;&nbsp;&nbsp; 0.00,&nbsp;&nbsp;&nbsp; &nbsp; 0.00,&nbsp;&nbsp;&nbsp; 1.68,&nbsp;&nbsp;&nbsp; 1.68,&nbsp;&nbsp;&nbsp; &nbsp; 0.00,&nbsp;&nbsp;&nbsp; 0.00,&nbsp;&nbsp; 0,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2848,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0 &nbsp; &nbsp;
</p>
<p>
    想直接粘贴是不可能的，于是想到自己的专业，立马就用语言写，于是有了php版的这个东西。用了phpexcel帮他完成了这个功能。
</p>
<h2>
    （二）思路
</h2>
<p>
    思路很简单，就是从源文件里取出数据，然后进行字符串的操作，然后再把这些数据分别放到要保存的文件里去。<br/>
</p>
<h2>
    （三）零散的东西
</h2>
<h4>
    （1）获取excel内容
</h4>
<pre class="brush:php;toolbar:false">//首先导入PHPExcel
require_once &#39;PHPExcel.php&#39;;

$filePath = &quot;test.xlsx&quot;;

//建立reader对象
$PHPReader = new PHPExcel_Reader_Excel2007();
if(!$PHPReader-&gt;canRead($filePath)){
    $PHPReader = new PHPExcel_Reader_Excel5();
    if(!$PHPReader-&gt;canRead($filePath)){
        echo &#39;no Excel&#39;;
        return ;
    }
}

//建立excel对象，此时你即可以通过excel对象读取文件，也可以通过它写入文件
$PHPExcel = $PHPReader-&gt;load($filePath);

/**读取excel文件中的第一个工作表*/
$currentSheet = $PHPExcel-&gt;getSheet(0);
/**取得最大的列号*/
$allColumn = $currentSheet-&gt;getHighestColumn();
/**取得一共有多少行*/
$allRow = $currentSheet-&gt;getHighestRow();

//循环读取每个单元格的内容。注意行从1开始，列从A开始
for($rowIndex=1;$rowIndex&lt;=$allRow;$rowIndex++){
    for($colIndex=&#39;A&#39;;$colIndex&lt;=$allColumn;$colIndex++){
        $addr = $colIndex.$rowIndex;
        $cell = $currentSheet-&gt;getCell($addr)-&gt;getValue();
        if($cell instanceof PHPExcel_RichText)     //富文本转换字符串
            $cell = $cell-&gt;__toString();
            
        echo $cell;
    
    }

}</pre>
<p>
    （2）官方simple文件<br/>
</p>
<pre class="brush:php;toolbar:false">&lt;?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set(&#39;display_errors&#39;, TRUE);
ini_set(&#39;display_startup_errors&#39;, TRUE);
date_default_timezone_set(&#39;Europe/London&#39;);

define(&#39;EOL&#39;,(PHP_SAPI == &#39;cli&#39;) ? PHP_EOL : &#39;&lt;br /&gt;&#39;);

/** Include PHPExcel */
require_once dirname(__FILE__) . &#39;/../Classes/PHPExcel.php&#39;;


// Create new PHPExcel object
echo date(&#39;H:i:s&#39;) , &quot; Create new PHPExcel object&quot; , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
echo date(&#39;H:i:s&#39;) , &quot; Set document properties&quot; , EOL;
$objPHPExcel-&gt;getProperties()-&gt;setCreator(&quot;Maarten Balliauw&quot;)
							 -&gt;setLastModifiedBy(&quot;Maarten Balliauw&quot;)
							 -&gt;setTitle(&quot;PHPExcel Test Document&quot;)
							 -&gt;setSubject(&quot;PHPExcel Test Document&quot;)
							 -&gt;setDescription(&quot;Test document for PHPExcel, generated using PHP classes.&quot;)
							 -&gt;setKeywords(&quot;office PHPExcel php&quot;)
							 -&gt;setCategory(&quot;Test result file&quot;);


// Add some data
echo date(&#39;H:i:s&#39;) , &quot; Add some data&quot; , EOL;
$objPHPExcel-&gt;setActiveSheetIndex(0)
            -&gt;setCellValue(&#39;A1&#39;, &#39;Hello&#39;)
            -&gt;setCellValue(&#39;B2&#39;, &#39;world!&#39;)
            -&gt;setCellValue(&#39;C1&#39;, &#39;Hello&#39;)
            -&gt;setCellValue(&#39;D2&#39;, &#39;world!&#39;);

// Miscellaneous glyphs, UTF-8
$objPHPExcel-&gt;setActiveSheetIndex(0)
            -&gt;setCellValue(&#39;A4&#39;, &#39;Miscellaneous glyphs&#39;)
            -&gt;setCellValue(&#39;A5&#39;, &#39;éàèùâêîôûëïüÿäöüç&#39;);


$objPHPExcel-&gt;getActiveSheet()-&gt;setCellValue(&#39;A8&#39;,&quot;Hello\nWorld&quot;);
$objPHPExcel-&gt;getActiveSheet()-&gt;getRowDimension(8)-&gt;setRowHeight(-1);
$objPHPExcel-&gt;getActiveSheet()-&gt;getStyle(&#39;A8&#39;)-&gt;getAlignment()-&gt;setWrapText(true);


// Rename worksheet
echo date(&#39;H:i:s&#39;) , &quot; Rename worksheet&quot; , EOL;
$objPHPExcel-&gt;getActiveSheet()-&gt;setTitle(&#39;Simple&#39;);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel-&gt;setActiveSheetIndex(0);


// Save Excel 2007 file
echo date(&#39;H:i:s&#39;) , &quot; Write to Excel2007 format&quot; , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, &#39;Excel2007&#39;);
$objWriter-&gt;save(str_replace(&#39;.php&#39;, &#39;.xlsx&#39;, __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date(&#39;H:i:s&#39;) , &quot; File written to &quot; , str_replace(&#39;.php&#39;, &#39;.xlsx&#39;, pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo &#39;Call time to write Workbook was &#39; , sprintf(&#39;%.4f&#39;,$callTime) , &quot; seconds&quot; , EOL;
// Echo memory usage
echo date(&#39;H:i:s&#39;) , &#39; Current memory usage: &#39; , (memory_get_usage(true) / 1024 / 1024) , &quot; MB&quot; , EOL;


// Save Excel 95 file
echo date(&#39;H:i:s&#39;) , &quot; Write to Excel5 format&quot; , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, &#39;Excel5&#39;);
$objWriter-&gt;save(str_replace(&#39;.php&#39;, &#39;.xls&#39;, __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date(&#39;H:i:s&#39;) , &quot; File written to &quot; , str_replace(&#39;.php&#39;, &#39;.xls&#39;, pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo &#39;Call time to write Workbook was &#39; , sprintf(&#39;%.4f&#39;,$callTime) , &quot; seconds&quot; , EOL;
// Echo memory usage
echo date(&#39;H:i:s&#39;) , &#39; Current memory usage: &#39; , (memory_get_usage(true) / 1024 / 1024) , &quot; MB&quot; , EOL;


// Echo memory peak usage
echo date(&#39;H:i:s&#39;) , &quot; Peak memory usage: &quot; , (memory_get_peak_usage(true) / 1024 / 1024) , &quot; MB&quot; , EOL;

// Echo done
echo date(&#39;H:i:s&#39;) , &quot; Done writing files&quot; , EOL;
echo &#39;Files have been created in &#39; , getcwd() , EOL;</pre>
<h3>
    （3）官方reader文件
</h3>
<pre class="brush:php;toolbar:false">&lt;?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

error_reporting(E_ALL);
ini_set(&#39;display_errors&#39;, TRUE);
ini_set(&#39;display_startup_errors&#39;, TRUE);

define(&#39;EOL&#39;,(PHP_SAPI == &#39;cli&#39;) ? PHP_EOL : &#39;&lt;br /&gt;&#39;);

date_default_timezone_set(&#39;Europe/London&#39;);

/** Include PHPExcel_IOFactory */
require_once dirname(__FILE__) . &#39;/../Classes/PHPExcel/IOFactory.php&#39;;


if (!file_exists(&quot;05featuredemo.xlsx&quot;)) {
	exit(&quot;Please run 05featuredemo.php first.&quot; . EOL);
}

echo date(&#39;H:i:s&#39;) , &quot; Load from Excel2007 file&quot; , EOL;
$callStartTime = microtime(true);

$objPHPExcel = PHPExcel_IOFactory::load(&quot;05featuredemo.xlsx&quot;);

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;
echo &#39;Call time to read Workbook was &#39; , sprintf(&#39;%.4f&#39;,$callTime) , &quot; seconds&quot; , EOL;
// Echo memory usage
echo date(&#39;H:i:s&#39;) , &#39; Current memory usage: &#39; , (memory_get_usage(true) / 1024 / 1024) , &quot; MB&quot; , EOL;


echo date(&#39;H:i:s&#39;) , &quot; Write to Excel2007 format&quot; , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, &#39;Excel2007&#39;);
$objWriter-&gt;save(str_replace(&#39;.php&#39;, &#39;.xlsx&#39;, __FILE__));

$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date(&#39;H:i:s&#39;) , &quot; File written to &quot; , str_replace(&#39;.php&#39;, &#39;.xlsx&#39;, pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo &#39;Call time to write Workbook was &#39; , sprintf(&#39;%.4f&#39;,$callTime) , &quot; seconds&quot; , EOL;
// Echo memory usage
echo date(&#39;H:i:s&#39;) , &#39; Current memory usage: &#39; , (memory_get_usage(true) / 1024 / 1024) , &quot; MB&quot; , EOL;


// Echo memory peak usage
echo date(&#39;H:i:s&#39;) , &quot; Peak memory usage: &quot; , (memory_get_peak_usage(true) / 1024 / 1024) , &quot; MB&quot; , EOL;

// Echo done
echo date(&#39;H:i:s&#39;) , &quot; Done writing file&quot; , EOL;
echo &#39;File has been created in &#39; , getcwd() , EOL;</pre>
<h2>
    （四）不足之处
</h2>
<p>
    phpexcel的内置设置,让0.00，直接存成0.<br/>
</p>
<html>
<head>
<title>Lib</title>
<style>
    td{width:130px;border:1px ridge black}
</style>
<script type="text/javascript">
function Table()
{ 
    var table = document.getElementById('tbl'),
        tr = table.getElementsByTagName('tr'),
        rows = tr.length;
    for (var i=1; i<rows; i++){
		var col = tr[i].getElementsByTagName('td');
        var tmp = col[0].innerHTML;
        col[0].innerHTML = col[1].innerHTML;
        col[1].innerHTML = tmp;
    }
}
</script>
</head>
<body>
<?php
    //открываем файл, создаем анализатор и подключаем функции
	$filename="library.xml";
	if(!($file=fopen($filename,"r"))) die("File open error!");
	$fp=xml_parser_create();
	xml_parser_set_option($fp, XML_OPTION_CASE_FOLDING, false);
	$i="";
	//метод обработки открывающего тега
	function startElementHandler($parser, $name, $attribs){
		global $i;
		$i=$name;
		switch ($name){
			case "library":
			$str='<table id="tbl" style="border:3px ridge black;margin:150px auto;">
			<tr style="font-size:18pt;font-weight:bold;text-align:center;"><td colspan="4">Library</td></tr>
			<tr style="font-weight:bold;text-align:center;">
			<td>Author</td><td>Name</td><td>Price</td><td>Rating</td></tr>';
			echo($str);
			break;
			case "book":
			$str='<tr>';
			echo($str);
			break;
			case "author":
			$str='<td>';
			echo($str);
			break;
			case "title":
			$str='<td style="font-weight:bold;">';
			echo($str);
			break;
			case "price":
			$str='<td>';
			echo($str);
			break;
			case "rating":
			$str='<td style="font-style:italic;">';
			echo($str);
			break;
		}
	}
	//метод обработки закрывающего тега
	function endElementHandler($parser, $name){
		global $i;
		$i="";
		switch ($name){
			case "library":
			$str='</table>';
			echo($str);
			break;
			case "book":
			$str="</tr>\r\n";
			echo($str);
			break;
			case "author":
			$str="</td>\r\n";
			echo($str);
			break;
			case "title":
			$str="</td>\r\n";
			echo($str);
			break;
			case "price":
			$str="</td>\r\n";
			echo($str);
			break;
			case "rating":
			$str="</td>\r\n";
			echo($str);
			break;
		}
	}
	//метод обработки данных
	function charDataHandler($parser, $data){
		global $i;
		switch($i){
			case "author":
			echo($data);
			break;
			case "title":
			echo($data);
			break;
			case "price":
			echo($data.' руб.');
			break;
			case "rating":
			switch($data){
				case '2':
				$str="Плохо";
				break;
				case '3':
				$str="Нормально";
				break;
				case '4':
				$str="Хорошо";
				break;
				case '5':
				$str="Отлично";
				break;
				default:
			}
			echo ($str);
			break;
		}
	}
	//подвязка анализаторов открывающего и закрывающего тегов
	xml_set_element_handler($fp, "startElementHandler", "endElementHandler");
	//подвязка метода анализа символов
	xml_set_character_data_handler($fp,"charDataHandler");
	//цикл обработки файла порциями
	while ($data=fread($file, 4096)) if(!(xml_parse($fp, $data, feof($file))))
	    die(sprintf("Error %s in line %i in file %s", xml_error_string(xml_get_error_code($fp)), xml_get_current_line_number(), $filename));
	fclose($file);
	//удаляем анализатор
	xml_parser_free($fp);
?>
</body>
</html>
<script>
Table();
</script>
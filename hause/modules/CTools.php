<?if(!$B_PROLOG_M) die();?>
<?class CTools{
	//////////// возврашает текущей адрес
	public static function GetURL(){
		$arRes = '/';	
		$URL = $_SERVER['REQUEST_URI'];		
		return $URL;
	}
	//////////// возврашает текущей адрес без параметров
	public static function GetCurPage(){
		$LINK = CTools::GetURL();
		$arLINK	= explode( '?' , $LINK );
		return $arLINK[0];
	}
	////////////////// транслит
	public static function translit($str, $params = array())	{
		$search['а'] = 'a';		$search['б'] = 'b';		$search['в'] = 'v';		$search['г'] = 'g';		$search['д'] = 'd';		$search['е'] = 'e';		$search['ё'] = 'ye';
		$search['ж'] = 'zh';	$search['з'] = 'z';		$search['и'] = 'i';		$search['й'] = 'y';		$search['к'] = 'k';		$search['л'] = 'l';		$search['м'] = 'm';
		$search['н'] = 'n';		$search['о'] = 'o';		$search['п'] = 'p';		$search['р'] = 'r';		$search['с'] = 's';		$search['т'] = 't';		$search['у'] = 'u';
		$search['ф'] = 'f';		$search['х'] = 'kh';	$search['ц'] = 'ts';	$search['ч'] = 'ch';	$search['ш'] = 'sh';	$search['щ'] = 'shch';	$search['ъ'] = '';
		$search['ы'] = 'y';		$search['ь'] = '';		$search['э'] = 'e';		$search['ю'] = 'yu';	$search['я'] = 'ya';	$search['А'] = 'A';		$search['Б'] = 'B';
		$search['В'] = 'V';		$search['Г'] = 'G';		$search['Д'] = 'D';		$search['Е'] = 'E';		$search['Ё'] = 'YE';	$search['Ж'] = 'ZH';	$search['З'] = 'Z';
		$search['И'] = 'I';		$search['Й'] = 'Y';		$search['К'] = 'K';		$search['Л'] = 'L';		$search['М'] = 'M';		$search['Н'] = 'N';		$search['О'] = 'O';
		$search['П'] = 'P';		$search['Р'] = 'R';		$search['С'] = 'S';		$search['Т'] = 'T';		$search['У'] = 'U';		$search['Ф'] = 'F';		$search['Х'] = 'KH';
		$search['Ц'] = 'TS';	$search['Ч'] = 'CH';	$search['Ш'] = 'SH';	$search['Щ'] = 'SHCH';	$search['Ъ'] = '';		$search['Ы'] = 'Y';		$search['Ь'] = '';
		$search['Э'] = 'E';		$search['Ю'] = 'YU';	$search['Я'] = 'YA';	$search['\xb3'] = 'i';	$search['\xb2'] = 'I';	$search['\xbf'] = 'i';	$search['\xaf'] = 'I';
		$search['\xb4'] = 'g';	$search['\xa5'] = 'G';	
		
		$defaultParams = array(
			"max_len"					=> 100,		// длинна 
			"change_case"				=> 'U',		// L - нижний , U - ВЕРХНИЙ
			"replace_space"				=> '_',		// _ пробелы
			"replace_other"				=> '_',		// _ все остальный
			"delete_repeat_replace"		=> true,	// удалять повтор пробелы
		);
		foreach($defaultParams as $key => $value){
			if(!array_key_exists($key, $params)){
				$params[$key] = $value;
			}			
		}
		$str = trim($str);
		
		$str_new = '';
		$last_chr_new = '';	
		$len = strlen($str);		
		 
		
		for($i = 0; $i < $len; $i++){
			$chr = substr($str, $i, 1);		
			
			if(preg_match("/[a-zA-Z0-9]/", $chr)){
				$chr_new = $chr;				
			}elseif(preg_match("/\\s/", $chr)){
				if (!$params["delete_repeat_replace"] || ($i > 0 && $last_chr_new != $params["replace_space"])){
					$chr_new = $params["replace_space"];
				}else{
					$chr_new = '';
				}
			}else{			
				if(array_key_exists($chr, $search)){
					$chr_new = $search[$chr];
				}else{
					if (!$params["delete_repeat_replace"] || ($i > 0 && $i != $len-1 && $last_chr_new != $params["replace_other"])){
						$chr_new = $params["replace_other"];
					}else{
						$chr_new = '';
					}
				}
			}			
			if(strlen($chr_new)){
				if($params["change_case"] == "L" || $params["change_case"] == "l"){
					$chr_new = strtolower($chr_new);
				}elseif($params["change_case"] == "U" || $params["change_case"] == "u"){
					$chr_new = strtoupper($chr_new);
				}
				$str_new .= $chr_new;
				$last_chr_new = $chr_new;
			}
			if (strlen($str_new) >= $params["max_len"])
				break;			
		}
		return $str_new;
	}
	/////////////////// сортировка по полю
	public static function my_sort($arr, $pole){
		$arRes = array();
		foreach($arr as $v){
			$array2[] = $v[$pole];
		}	
		natcasesort($array2);	
		foreach($array2 as $k => $v){
			$arRes[] = $arr[$k];	
		}	
		return $arRes;	
	}
	/////////////////редирект
	public static function LocalRedirect($url){
		header("Location: ".$url);
		exit;
	}
	/// превращение даты из метки в строку
	public static function FormatDate( $format = "d.m.Y h:i", $now = false){
		$MESS["MONTH_1"] = "Январь";
		$MESS["MONTH_2"] = "Февраль";
		$MESS["MONTH_3"] = "Март";
		$MESS["MONTH_4"] = "Апрель";
		$MESS["MONTH_5"] = "Май";
		$MESS["MONTH_6"] = "Июнь";
		$MESS["MONTH_7"] = "Июль";
		$MESS["MONTH_8"] = "Август";
		$MESS["MONTH_9"] = "Сентябрь";
		$MESS["MONTH_10"] = "Октябрь";
		$MESS["MONTH_11"] = "Ноябрь";
		$MESS["MONTH_12"] = "Декабрь";
		$MESS["MONTH_1_S"] = "Января";
		$MESS["MONTH_2_S"] = "Февраля";
		$MESS["MONTH_3_S"] = "Марта";
		$MESS["MONTH_4_S"] = "Апреля";
		$MESS["MONTH_5_S"] = "Мая";
		$MESS["MONTH_6_S"] = "Июня";
		$MESS["MONTH_7_S"] = "Июля";
		$MESS["MONTH_8_S"] = "Августа";
		$MESS["MONTH_9_S"] = "Сентября";
		$MESS["MONTH_10_S"] = "Октября";
		$MESS["MONTH_11_S"] = "Ноября";
		$MESS["MONTH_12_S"] = "Декабря";
		$MESS["MON_1"] = "Янв";
		$MESS["MON_2"] = "Фев";
		$MESS["MON_3"] = "Мар";
		$MESS["MON_4"] = "Апр";
		$MESS["MON_5"] = "Май";
		$MESS["MON_6"] = "Июн";
		$MESS["MON_7"] = "Июл";
		$MESS["MON_8"] = "Авг";
		$MESS["MON_9"] = "Сен";
		$MESS["MON_10"] = "Окт";
		$MESS["MON_11"] = "Ноя";
		$MESS["MON_12"] = "Дек";
		$MESS["DAY_OF_WEEK_0"] = "Воскресенье";
		$MESS["DAY_OF_WEEK_1"] = "Понедельник";
		$MESS["DAY_OF_WEEK_2"] = "Вторник";
		$MESS["DAY_OF_WEEK_3"] = "Среда";
		$MESS["DAY_OF_WEEK_4"] = "Четверг";
		$MESS["DAY_OF_WEEK_5"] = "Пятница";
		$MESS["DAY_OF_WEEK_6"] = "Суббота";
		$MESS["DOW_0"] = "Вс";
		$MESS["DOW_1"] = "Пн";
		$MESS["DOW_2"] = "Вт";
		$MESS["DOW_3"] = "Ср";
		$MESS["DOW_4"] = "Чт";
		$MESS["DOW_5"] = "Пт";
		$MESS["DOW_6"] = "Сб";
		if($now === false)
			$now = time();
		
		$bCutZeroTime = false;			
		if (substr($format, 0, 1) == '^') {
			$bCutZeroTime = true;
			$format = substr($format, 1);
		}
		$arFormatParts = preg_split(
			"/(F|f|M|l|D)/", 
			$format, 
			0, 
			PREG_SPLIT_DELIM_CAPTURE
		);
		$result = "";
		foreach($arFormatParts as $format_part){
			switch($format_part){
				case "":
				break;
				case "F":
					$result .= $MESS["MONTH_".date("n", $now)."_S"];
				break;
				case "f":
					$result .= $MESS["MONTH_".date("n", $now)];
				break;
				case "M":
					$result .= $MESS["MON_".date("n", $now)];
				break;
				case "l":
					$result .= $MESS["DAY_OF_WEEK_".date("w", $now)];
				break;
				case "D":
					$result .= $MESS["DOW_".date("w", $now)];
				break;
				default:
					$result .= date($format_part, $now);
				break;
			}
		}
		if ($bCutZeroTime)
			$result = preg_replace(
				array(
					"/\\s*00:00:00\\s*/", 
					"/(\\d\\d:\\d\\d)(:00)/", 
					"/(\\s*00:00\\s*)(?!:)/"
				),
				array("", "\\1", ""),
				$result
			);
		return $result;
	}
	// рекурсивно в массиве меняем кодировку всех данных на ЮТФ - 8
	public static function arrUTF ($arr){
		array_walk_recursive($arr , function($item, $key){
			$item = htmlspecialchars($item, null, "utf-8");
		});
		return $arr;
	}
	// проверка валидности почты
	public static function check_email( $email ){
		if(strlen($email) > 320){
			return false;
		}
		static $atom = "=_0-9a-z+~'!\$&*^`|\\#%/?{}-";
		if(preg_match("#^[".$atom."]+(\\.[".$atom."]+)*@(([-0-9a-z_]+\\.)+)([a-z0-9-]{2,20})$#i", $email)){
			return true;
		}else{
			return false;
		}
	}
	///////////// для преобразования мсассива файлов в нормальную структуру
	public static function diverse_array($vector) { 
		$result = array(); 
		foreach($vector as $key1 => $value1) 
			foreach($value1 as $key2 => $value2) 
				$result[$key2][$key1] = $value2; 
		return $result; 
	} 
	//////////////////////// Формат цены
	public static function Price( $price ) {
		return number_format( $price, 0, '', '&nbsp;').' р.';
	}
}
?>
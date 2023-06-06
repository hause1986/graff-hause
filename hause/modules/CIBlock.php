<?if(!$B_PROLOG_M) die();?>
<?class CIBlock{
	//////////////////////////// filter
	public static function Operand( $cOperationType ){
		if(	$cOperationType	==	"N"	){
			$strOperation = "!=";
		}elseif( $cOperationType ==	"G"	)
            $strOperation = ">";
        elseif(	$cOperationType	==	"GE"	)
            $strOperation = ">=";
        elseif(	$cOperationType	==	"LE"	)
            $strOperation = "<=";
        elseif(	$cOperationType	==	"L"	)
            $strOperation = "<";
		elseif(	$cOperationType	==	"M"	)
			$strOperation = "LIKE";
        else
            $strOperation = "=";		
		return $strOperation;
	}	
	public static function FilterCreate($key, $val, $type, $cOperationType){
		$strOperation = CIBlock::Operand( $cOperationType );		
		switch ($type){
			case "string":
				if(				
						$cOperationType == "N"
					||	$cOperationType == "M"
				){
					$res = " ".$key." ".$strOperation." '".$val."'";					
				}else{
					$res = " ".$key." = '".$val."'";
				}
			break;
			case "number":
				$res = " ".$key." ".$strOperation." '".intval($val)."'";
			break;
		}
		return $res;
	}
	/////////////////////////////////////////////////////
	public static function MkOperationFilter($key){
		static $double_char = array(
			">=" => "GE", //greater or equal
			"<=" => "LE", //less or equal
		);
		static $single_char = array(
			">" => "G", //greater
			"<" => "L", //less
			"!" => "N", // not field LIKE val
			"%"	=> "M",	//LIKE mask 	
		);
		$key = (string)$key;
		if ( $key == '' )
			return array(
				"FIELD"		=> $key,
				"OPERATION" => "E"
			);

		$op = substr( $key, 0, 2 );
		if( $op && isset( $double_char[$op] ) )
			return array(
				"FIELD"			=> substr( $key, 2 ),
				"OPERATION"		=> $double_char[$op]
			);		
		$op = substr( $key, 0, 1 );
		if( $op && isset( $single_char[$op] ) )
			return array(
				"FIELD"		=>	substr( $key, 1 ),
				"OPERATION"	=>	$single_char[$op]
			);
		return array(
			"FIELD"		=>	$key,
			"OPERATION"	=>	"E"
		);
	}
	///////////////////////////////////////////////////
	public static function GetByID($ID){
		global $db;	
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_iblok_ib WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
		}
		return $res;
	}
	/////////////////////////////////////////////////////////
	public static function GetList($arOrder=Array("SORT"=>"ASC"), $arFilter=Array(),$count_el = 0){
		global $db;	
		foreach($arFilter as $key => $val){
			$res = CIBlock::MkOperationFilter($key);
			$key = strtoupper($res["FIELD"]);
			$cOperationType = $res["OPERATION"];
			switch($key){
				case "ACTIVE":
				case "NAME":
				case "CODE":
					$sql = CIBlock::FilterCreate($key, $val, "string", $cOperationType);
				break;
				case "CREATE_DATE":
				case "UP_DATE":
				case "ID":
					$sql = CIBlock::FilterCreate($key, $val, "number", $cOperationType);
				break;
				default:
					$sql = "";
				break;
			}
			if(strlen($sql))
				$strSqlSearch .= " AND  (".$sql.") ";
		}		
		
		$arSqlOrder = array();
		foreach($arOrder as $by => $order){
			$by = strtoupper($by);
			$order = strtoupper($order) == "ASC"? "ASC": "DESC";
			if(
				$by === "ID"			||
				$by === "NAME"			||
				$by === "ACTIVE"		||
				$by === "SORT"			||
				$by === "CODE"			||
				$by === "CREATE_DATE"	||
				$by === "UP_DATE"
			){
				$arSqlOrder[] = " ".$by." ".$order;
			}
		}        
        if(count($arSqlOrder) > 0)
            $strSqlOrder = " ORDER BY ".implode(", ", $arSqlOrder)." ";
        else
            $strSqlOrder = "";
		if(intval($count_el) > 0){
			$lim = " LIMIT ".intval($count_el);
		}else{
			$lim = "";
		}
		
		$query = "SELECT * FROM h_iblok_ib WHERE 1=1 ".$strSqlSearch.$strSqlOrder.$lim;
		
		$arRes = $db->select($query);
		return $arRes;
	}
	/////////////////////////////////////////////////////
	function Add($arFields){
		global $db;
		$res = false;
		if(strlen($arFields["NAME"])<1){
			return false;
		}
		if(!isset($arFields["ACTIVE"])){
			$arFields["ACTIVE"] = "N";
		}		
		if(!isset($arFields["SORT"])){
			$arFields["SORT"] = "500";
		}
		if(!isset($arFields["CODE"])){
			$arFields["CODE"] = $arFields["NAME"];
		}		
		foreach($arFields as $k => $v){
			switch($k){
				case "SORT":
					$v = intval($v);
					if($v > 0){
						$arRes[$k] = $v;
					}else{
						$arRes[$k] = 500;
					}
				break;
				case "CODE":
					$arRes[$k] = CTools::translit($v);
				break;
				case "ACTIVE":
					if($v == "Y"){
						$arRes[$k] = "Y";
					}else{
						$arRes[$k] = "N";
					}
				break;
				case "NAME":
				case "DESCRIPT_TEXT":
					if(strlen($v) > 0){
						$arRes[$k] = trim(htmlspecialchars($v));
					}
				break;
			}
		}	
		$arRes["CREATE_DATE"] = time();
		$arRes["UP_DATE"] = time();
		$query = insert_db(
			"h_iblok_ib",
			$arRes
		);
		$res = $db->query($query);
		return $res;
	}
	//////////////////////////////////////////////////////////
	function Update($ID, $arFields){
		global $db;
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$arRes = array(); 
			foreach($arFields as $k => $v){
				switch ($k){
					case "ACTIVE":
						$arRes["FIELD"][$k] = ($v=="Y" ? "Y" : "N");
					break;
					case "SORT":
						$v = intval($v);
						if($k == "SORT" && $v < 1)
							$v = 500;
						$arRes["FIELD"][$k] = $v;
					break;
					case "CODE":
						$arRes["FIELD"][$k] = CTools::translit($v);
					break;
					case "NAME":
					case "DESCRIPT_TEXT":
						$arRes["FIELD"][$k] =trim(htmlspecialchars($v));
					break;
				}
			}
			$arRes["FIELD"]["UP_DATE"] = time();
			$query = update_db(
				"h_iblok_ib",
				$arRes["FIELD"],
				$ID
			);			
			$res = $db->query($query);
		}		
		
		return $res;
	}
	/////////////////////////////////////////////////////////////
	public static function Delete($ID){
		global $db;
		$ID = intval($ID);
		if($ID > 0){
			$query = "DELETE FROM h_iblok_ib WHERE ID = ".$ID;
			$db->query($query);
			$res_blok = CIBlockElement::GetList(
				array(),
				array(),
				array(
					"ID_IBLOCK" => $ID,
				)
			);
			foreach($res_blok as $v){
				CIBlockElement::Delete($v['ID']);
			}
			$res_prop = CProp::GetPropList(
				array(),
				array( "ID_IBLOCK" => $ID )
			);
			foreach($res_prop as $v){
				CProp::PropDelete($v['ID']);
			}			
		}
	}
}?>
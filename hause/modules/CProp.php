<?if(!$B_PROLOG_M) die();?>
<?class CProp{
	//////////////////////////// filter
	public static function FilterCreate($key, $val, $type, $cOperationType){
		if($cOperationType=="N"){
			$strOperation = "!=";
		}elseif($cOperationType=="G")
            $strOperation = ">";
        elseif($cOperationType=="GE")
            $strOperation = ">=";
        elseif($cOperationType=="LE")
            $strOperation = "<=";
        elseif($cOperationType=="L")
            $strOperation = "<";
        else
            $strOperation = "=";
		switch ($type){
			case "string":
				if($cOperationType == "N"){
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
			">="=>"GE", //greater or equal
			"<="=>"LE", //less or equal
		);
		static $single_char = array(
			">"=>"G", //greater
			"<"=>"L", //less
			"!"=>"N", // not field LIKE val
		);
		$key = (string)$key;
		if ($key == '')
			return array("FIELD"=>$key, "OPERATION"=>"E");

		$op = substr($key,0,2);
		if($op && isset($double_char[$op]))
			return array("FIELD"=>substr($key,2), "OPERATION"=>$double_char[$op]);
		
		$op = substr($key,0,1);
		if($op && isset($single_char[$op]))
			return array("FIELD"=>substr($key,1), "OPERATION"=>$single_char[$op]);

		return array("FIELD"=>$key, "OPERATION"=>"E");
	}
	///////////////////////////////////////////////////
	public static function GetList($arOrder=Array("SORT"=>"ASC"), $arFilter=Array(),$count_el = 0){
		global $db;
		
		foreach($arFilter as $key => $val){
			$res = CIBlock::MkOperationFilter($key);
			$key = strtoupper($res["FIELD"]);
			$cOperationType = $res["OPERATION"];
			switch($key){				
				case "NAME":
				case "TYPE":
					$sql = CIBlock::FilterCreate($key, $val, "string", $cOperationType);
				break;
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
				$by === "TYPE"			

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
		
		$query = "SELECT * FROM h_prop_type WHERE 1=1 ".$strSqlSearch.$strSqlOrder.$lim;
		$arRes = $db->select($query);
		return $arRes;
	}
	public static function GetByID($ID){
		global $db;	
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_prop_type WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
		}
		return $res;
	}
	
	function Add($arFields){
		global $db;
		$res = false;
		if(strlen($arFields["NAME"])<1){
			return false;
		}
		if(!isset($arFields["TYPE"])){
			$arFields["TYPE"] = $arFields["TYPE"];
		}		
		foreach($arFields as $k => $v){
			switch($k){
				case "TYPE":
					$arRes[$k] = CTools::translit($v);
				break;
				case "NAME":
					if(strlen($v) > 0){
						$arRes[$k] = trim(htmlspecialchars($v));
					}
				break;
			}
		}
		$query = insert_db(
			"h_prop_type",
			$arRes
		);
		$res = $db->query($query);
		return $res;
	}	
	
	function Update($ID, $arFields){
		global $db;
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$arRes = array(); 
			foreach($arFields as $k => $v){
				switch ($k){
					case "TYPE":
						$arRes[$k] = CTools::translit($v);
					break;
					case "NAME":					
						$arRes[$k] =trim(htmlspecialchars($v));
					break;
				}
			}			
			$query = update_db(
				"h_prop_type",
				$arRes,
				$ID
			);			
			$res = $db->query($query);
		}		
		
		return $res;
	}	
	//function Delete($ID){}
	/*******************************************/
	public static function GetPropByID($ID){
		global $db;	
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_prop_iblock WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
		}
		return $res;
	}	
	public static function GetPropList( $arOrder=Array("SORT"=>"ASC"), $arFilter=Array() ){	
		global $db;		
		$strSqlSearch = "";
		foreach($arFilter as $key => $val){			
			switch($key){
				case "ACTIVE":				
					$val = strtoupper($val) == "Y"? "Y": "N";
				break;
			}
			$res = CIBlock::MkOperationFilter($key);
			$key = strtoupper($res["FIELD"]);
			$cOperationType = $res["OPERATION"];			
			
			switch($key){				
				case "ID_IBLOCK":
					$sql = CIBlock::FilterCreate($key, $val, "number", $cOperationType);
				break;				
				case "ACTIVE":
				case "CODE":
					$sql = CIBlock::FilterCreate($key, $val, "string", $cOperationType);
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
				$by === "SORT"			||
				$by === "CODE"
			){
				$arSqlOrder[] = " ".$by." ".$order;
			}
		}
		if(count($arSqlOrder) > 0)
			$strSqlOrder = " ORDER BY ".implode(", ", $arSqlOrder)." ";
		else
			$strSqlOrder = "";		
		$query = "
			SELECT 
				h_prop_iblock.ID 			as ID,
				h_prop_iblock.ID_IBLOCK		as ID_IBLOCK,
				h_prop_iblock.NAME			as NAME,
				h_prop_iblock.ID_PROP_TYPE	as ID_PROP_TYPE,
				h_prop_type.TYPE			as TYPE,
				h_prop_iblock.CODE			as CODE,
				h_prop_iblock.SORT			as SORT,
				h_prop_iblock.ACTIVE		as ACTIVE,
				h_prop_iblock.REQUIRED		as REQUIRED,
				h_prop_iblock.MULTIPLE		as MULTIPLE,
				h_prop_iblock.FLAG			as FLAG
			FROM
				h_prop_iblock,
				h_prop_type
			WHERE
					1 = 1
				AND	h_prop_type.ID = h_prop_iblock.ID_PROP_TYPE"
				. $strSqlSearch 
				. $strSqlOrder;		
		
		$res = $db->select($query);		
		return $res;
	}
	function AddPropMod($arFields){
		global $db;
		$res = false;
		$arRes = array();

		if(strlen($arFields["ID_IBLOCK"])<1){
			return false;
		}
		if(strlen($arFields["NAME"])<1){
			return false;
		}
		if(strlen($arFields["CODE"])<1){
			return false;
		}
		/////////////////////
		if(!isset($arFields["FLAG"])){
			$arFields["FLAG"] = "N";
		}
		if(!isset($arFields["MULTIPLE"])){
			$arFields["MULTIPLE"] = "N";
		}
		if(!isset($arFields["ACTIVE"])){
			$arFields["ACTIVE"] = "N";
		}
		if(!isset($arFields["REQUIRED"])){
			$arFields["REQUIRED"] = "N";
		}		
		if(!isset($arFields["SORT"])){
			$arFields["SORT"] = "500";
		}
		////////////////////////////		
		foreach($arFields as $k => $v){
			switch ($k){
				case "FLAG":
				case "MULTIPLE":
				case "REQUIRED":
				case "ACTIVE":
					if($v == "Y"){
						$arRes[$k] = "Y";
					}else{
						$arRes[$k] = "N";
					}
				break;
				case "SORT":
					$v = intval($v);
					if($v > 0){
						$arRes[$k] = $v;
					}else{
						$arRes[$k] = 500;
					}
				break;
				case "CODE":
				case "NAME":
					if(strlen($v) > 0){
						$arRes[$k] = trim(htmlspecialchars($v));
					}					
				break;				
				case "ID_IBLOCK":
				case "ID_PROP_TYPE":
					$arRes[$k] = intval($v);
				break;
			}
		}		
		$query = insert_db(
			"h_prop_iblock",
			$arRes
		);
		$res = $db->query($query);
		return $res;		
	}
	function UpdatePropMod( $ID , $arFields ){
		global $db;
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$arRes = array(); 
			//////////////////////////
			if(strlen($arFields["ID_IBLOCK"])<1){
				return false;
			}
			if(strlen($arFields["NAME"])<1){
				return false;
			}
			if(strlen($arFields["CODE"])<1){
				return false;
			}
			/////////////////////
			if(!isset($arFields["FLAG"])){
				$arFields["FLAG"] = "N";
			}
			if(!isset($arFields["MULTIPLE"])){
				$arFields["MULTIPLE"] = "N";
			}
			if(!isset($arFields["ACTIVE"])){
				$arFields["ACTIVE"] = "N";
			}
			if(!isset($arFields["REQUIRED"])){
				$arFields["REQUIRED"] = "N";
			}		
			if(!isset($arFields["SORT"])){
				$arFields["SORT"] = "500";
			}
			////////////////////////////
			foreach($arFields as $k => $v){
				switch ($k){
					case "FLAG":
					case "MULTIPLE":
					case "REQUIRED":
					case "ACTIVE":
						if($v == "Y"){
							$arRes[$k] = "Y";
						}else{
							$arRes[$k] = "N";
						}
					break;
					case "SORT":
						$v = intval($v);
						if($v > 0){
							$arRes[$k] = $v;
						}else{
							$arRes[$k] = 500;
						}
					break;
					case "CODE":
					case "NAME":
						if(strlen($v) > 0){
							$arRes[$k] = trim(htmlspecialchars($v));
						}					
					break;				
					case "ID_IBLOCK":
					case "ID_PROP_TYPE":
						$arRes[$k] = intval($v);
					break;
				}
			}
			//////////////////////////
			$arProp = CProp::GetPropByID( $ID );
			if(
					intval( $arFields['ID_PROP_TYPE'] )
				&&	$arProp['ID_PROP_TYPE'] != $arFields['ID_PROP_TYPE']
			){
				CProp::PropDelete( $ID );							
				$query = insert_db(
					"h_prop_iblock",
					$arRes					
				);			
			}else{				
				$query = update_db(
					"h_prop_iblock",
					$arRes,
					$ID
				);				
			}			
			///////////////////////////		
			$res = $db->query( $query );
		}		
		return $res;
	}
	public static function PropDelete( $ID ){
		global $db;
		$ID = intval($ID);
		if($ID > 0){			
			$query = "
				SELECT
					h_prop_type.TYPE		as TYPE
				FROM
				
					h_prop_iblock,
					h_prop_type
				WHERE
						h_prop_iblock.ID = '" . $ID . "'
					AND	h_prop_iblock.ID_PROP_TYPE = h_prop_type.ID
			";		
			$arPr = $db->selectRow( $query );				
			if( $arPr['TYPE'] == 'F' ){
				$query = "
					SELECT
						*
					FROM
						h_prop_value
					WHERE
						ID_PROP = '" . $ID . "'
				";
				$arPr = $db->select( $query );
				foreach( $arPr as $val ){					
					CFile::Delete( $val['VALUE'] );
				}				
			}			
			$query = "DELETE FROM h_prop_enum WHERE ID_PROP = ".$ID;
			$db->query( $query );
			$query = "DELETE FROM h_prop_iblock WHERE ID = ".$ID;
			$db->query( $query );				
			$query = "DELETE FROM h_prop_value WHERE ID_PROP = ".$ID;
			$db->query( $query );			
		}		
	}
	//****************************************************************//
	public static function GetPropEnum( $ID ){		///	($ID - тут привязка к Модулю)		
		global $db;	
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$arSqlOrder = array();
			$arSqlOrder[] = " SORT ASC";
			$strSqlOrder = " ORDER BY ".implode(", ", $arSqlOrder)." ";
			$query = "SELECT * FROM h_prop_enum WHERE ID_PROP = '".$ID."' " . $strSqlOrder;
			$res = $db->select($query);
		}
		return $res;				
	}
	function AddPropEnum( $ID, $arFields ){					//////////// добавляем знавения свойтв для Модуля ($ID - тут привязка к Модулю)
		global $db;
		$res = false;
		$arRes = array();
		
		if( !intval( $ID ) ){
			return false;
		}
		$arFields["ID_PROP"] = intval( $ID );		
		if( !strlen( $arFields["VALUE"] ) ){
			return false;
		}		
		/////////////////////
		if( !isset( $arFields["SORT"] ) ){
			$arFields["SORT"] = 500;
		}
		////////////////////////////		
		foreach($arFields as $k => $v){
			switch ($k){
				case "SORT":
					$v = intval($v);
					if($v > 0){
						$arRes[$k] = $v;
					}else{
						$arRes[$k] = 500;
					}
				break;
				case "CODE":
				case "VALUE":
					if(strlen($v) > 0){
						$arRes[$k] = trim(htmlspecialchars($v));
					}					
				break;
				case "ID_PROP":
					$arRes[$k] = intval($v);
				break;
			}
		}		
		$query = insert_db(
			"h_prop_enum",
			$arRes
		);
		$res = $db->query($query);
		return $res;		
	}
	function UpdatePropEnum( $ID, $arFields ){		//////////// добавляем знавения свойтв для элемента ($ID - тут значение самой записи в базе )
		global $db;
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$arRes = array(); 
			//////////////////////////
			if( !strlen( $arFields["VALUE"] ) ){
				return false;
			}
			/////////////////////
			if( !isset( $arFields["SORT"] ) ){
				$arFields["SORT"] = 500;
			}
			////////////////////////////
			foreach($arFields as $k => $v){
				switch ($k){			
					case "SORT":
						$v = intval($v);
						if($v > 0){
							$arRes[$k] = $v;
						}else{
							$arRes[$k] = 500;
						}
					break;
					case "CODE":
					case "VALUE":
						if(strlen($v) > 0){
							$arRes[$k] = trim(htmlspecialchars($v));
						}					
					break;			
				}
			}			
			$query = update_db(
				"h_prop_enum",
				$arRes,
				$ID
			);
			$res = $db->query($query);
		}		
		return $res;		
	}
	
	public static function DeletePropEnum( $ID ){
		global $db;
		$ID = intval($ID);
		if($ID > 0){
			$query = "DELETE FROM h_prop_enum WHERE ID = ".$ID;
			$db->query($query);			
		}
	}
	//	********************************************** //
	
	public static function GetPropListVal( $ID_IBLOCK, $ID_ELEMENT ){
		global $db;
		$res = false;		
		
		$arPr = CProp::GetPropList(
			array( 'SORT' => 'ASC' ),
			array(
				'ID_IBLOCK'	=>	$ID_IBLOCK,
				'ACTIVE'	=>	'Y',
			)
		);		
		foreach( $arPr as $v ){
			$arType = CProp::GetByID( $v['ID_PROP_TYPE'] );
			$query = "SELECT * FROM h_prop_value WHERE ID_ELEMENT = '" . $ID_ELEMENT . "' AND ID_PROP = '" . $v['ID'] . "'";			

			if( $v['MULTIPLE'] == 'Y' ){
				$arrres = $db->select($query);
				$VALUE = array();
				$ID_PROP_VALUE = array();
				foreach( $arrres as $vval ){
					$VALUE[] = $vval['VALUE'];
					$ID_PROP_VALUE[] = $vval['ID'];
				}					
			}else{
				$arrres = $db->selectRow($query);
				$VALUE = '';
				$ID_PROP_VALUE = '';
				
				$VALUE = $arrres['VALUE'];
				$ID_PROP_VALUE = $arrres['ID'];
			}				
			$res[$v['CODE']] = array(
				'ID'		=>	$v['ID'],
				'CODE'		=>	$v['CODE'],
				'NAME'		=>	$v['NAME'],
				'TYPE'		=>	$arType['TYPE'],
				'SORT'		=>	$v['SORT'],
				'REQUIRED'	=>	$v['REQUIRED'],
				'MULTIPLE'	=>	$v['MULTIPLE'],
				'FLAG'		=>	$v['FLAG'],
				'VALUE'		=>	$VALUE,
				'ID_PROP_VALUE' => $ID_PROP_VALUE,
			);
		}		
		return $res;
	}
	
	public static function GetPropVal( $ID_IBLOCK, $ID_ELEMENT, $CODE ){
		global $db;
		$res = false;
		
		$arPr = CProp::GetPropList(
			array( 'SORT' => 'ASC' ),
			array(
				'ID_IBLOCK'	=>	$ID_IBLOCK,
				'CODE'		=>	$CODE,
			)
		);
		$arPr = $arPr[0];
		
		$ID = $arPr['ID'];
		$arType = CProp::GetByID( $arPr['ID_PROP_TYPE'] );
		$query = "SELECT * FROM h_prop_value WHERE ID_ELEMENT = '" . $ID_ELEMENT . "' AND ID_PROP = '" . $ID . "'";
		
		if( $arPr['MULTIPLE'] == 'Y' ){
			$arrres = $db->select($query);
			$VALUE = array();
			$ID_PROP_VALUE = array();
			foreach( $arrres as $vval ){
				$VALUE[] = $vval['VALUE'];
				$ID_PROP_VALUE[] = $vval['ID'];
			}					
		}else{
			$arrres = $db->selectRow($query);
			$VALUE = '';
			$ID_PROP_VALUE = '';
			$VALUE = $arrres['VALUE'];
			$ID_PROP_VALUE = $arrres['ID'];
		}				
		$res = array(
			'ID'		=>	$arPr['ID'],
			'CODE'		=>	$arPr['CODE'],
			'NAME'		=>	$arPr['NAME'],
			'TYPE'		=>	$arType['TYPE'],
			'SORT'		=>	$arPr['SORT'],
			'REQUIRED'	=>	$arPr['REQUIRED'],
			'MULTIPLE'	=>	$arPr['MULTIPLE'],
			'FLAG'		=>	$arPr['FLAG'],
			'VALUE'		=>	$VALUE,
			'ID_PROP_VALUE' => $ID_PROP_VALUE,
		);	
			
		return $res;		
	}
	public static function SetPropVal( $ID_IBLOCK, $ID_ELEMENT, $CODE, $arVALUE ){		
		global $db;
		$query = "
			SELECT
				h_prop_iblock.ID		as ID,
				h_prop_type.TYPE		as TYPE,
				h_prop_iblock.MULTIPLE	as MULTIPLE
			FROM
				h_prop_iblock,
				h_prop_type
			WHERE
					ID_PROP_TYPE		= h_prop_type.ID
				AND	ID_IBLOCK			= '" . $ID_IBLOCK . "'
				AND	h_prop_iblock.CODE	= '" . $CODE . "'
		";
		$arPr = $db->selectRow( $query );		
		if( $arPr['MULTIPLE'] == 'Y' ){
			foreach( $arVALUE as $key => $val ){				
				$val = htmlspecialchars( $val );				
				$arKey = explode( '_', $key );					
				if( $arKey[0] == 'ID' && intval( $arKey[1] ) ){				
					if( strlen( $val ) ){
						$query = update_db(
							"h_prop_value",
							array( 'VALUE'	=>	$val ),
							intval( $arKey[1] )
						);						
						$db->query( $query );
					}else{
						CProp::DeletePropVal( intval( $arKey[1] ) );
					}
				}elseif( strlen( $val ) ){					
					//$query = "DELETE FROM h_prop_value WHERE ID_PROP = '" . $arPr['ID'] . "' AND ID_ELEMENT ='" . $ID_ELEMENT . '"';					
					//$db->query( $query );	/// иначе в мультиселекме не очищается ни чего					
					$query = insert_db(
						"h_prop_value",
						array(
							'ID_PROP'		=>	$arPr['ID'],
							'VALUE'			=>	$val,
							'ID_ELEMENT'	=>	$ID_ELEMENT,
						)
					);					
					$db->query( $query );
				}
			}			
		}else{
			$arVALUE = htmlspecialchars( $arVALUE );			
			$query = "
				SELECT
					ID
				FROM
					h_prop_value
				WHERE
						ID_ELEMENT	= '" . $ID_ELEMENT . "'
					AND	ID_PROP		= '" . $arPr['ID'] . "'
			";
			$arPrVal = $db->selectRow( $query );
			if( intval( $arPrVal['ID'] ) ){
				if( strlen( $arVALUE ) ){					
					$query = update_db(
						"h_prop_value",
						array( 'VALUE'	=>	$arVALUE ),
						$arPrVal['ID']
					);					
					$db->query( $query );
				}else{
					CProp::DeletePropVal( $arPrVal['ID'] );
				}
			}else{
				$query = insert_db(
					"h_prop_value",
					array(
						'ID_PROP'		=>	$arPr['ID'],
						'VALUE'			=>	$arVALUE,
						'ID_ELEMENT'	=>	$ID_ELEMENT,
					)
				);
				$db->query( $query );					
			}
		}			
	}

	public static function DeletePropVal( $ID ){
		global $db;
		$ID = intval($ID);
		if($ID > 0){
			$query = "DELETE FROM h_prop_value WHERE ID = '" . $ID . "' ";
			$db->query($query);
		}	
	}
}?>
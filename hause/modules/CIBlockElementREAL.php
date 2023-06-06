<?if(!$B_PROLOG_M) die();?>
<?class CIBlockElement{
	/////////////////////////////
	public static function GetByID($ID, $PROP = 'Y' ){
		global $db;	
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_iblok_elements WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
			if( $PROP == 'Y' ){
				///////////////////////GetPropList			
				$res['PROP'] = CProp::GetPropListVal( $res['ID_IBLOCK'], $res['ID'] );
			}
		}
		return $res;		
	}
	///////////////////////////////////////////
	public static function GetList(
		$arOrder = Array( "SORT" => "ASC" ),
		$arSelect = Array(),
		$arFilter = Array(),
		$arNavi = false
	){
		global $db;
		$strSqlSearch = "";
		foreach( $arFilter as $key => $val ){
			switch( $key ){
				case "ACTIVE":				
					$val = strtoupper( $val ) == "Y"? "Y": "N";
				break;
			}
			$res = CIBlock::MkOperationFilter( $key );
			$key = strtoupper( $res["FIELD"] );
			$cOperationType = $res["OPERATION"];
			switch( $key ){
				case "ACTIVE":		
				case "NAME":
				case "CODE":
					$sql = CIBlock::FilterCreate( $key, $val, "string", $cOperationType );
				break;
				case "CREATE_DATE":
				case "UP_DATE":
				case "ID":
				case "ID_IBLOCK":					
					$sql = CIBlock::FilterCreate( $key, $val, "number", $cOperationType );
				break;
				default:
					$sql = "";
				break;
			}
			if( strlen( $sql ) )
				$strSqlSearch .= " AND  ( " . $sql . " ) ";
		}		
		$arSqlOrder = array();
		foreach( $arOrder as $by => $order ){
			$by = strtoupper( $by );
			$order = strtoupper( $order ) == "ASC" ? "ASC" : "DESC";
			if(
				$by === "ID"			||
				$by === "ID_IBLOCK"		||
				$by === "NAME"			||
				$by === "ACTIVE"		||
				$by === "SORT"			||
				$by === "CODE"			||					
				$by === "CREATE_DATE"	||
				$by === "UP_DATE"					
			){
				$arSqlOrder[] = " " . $by . " " . $order;
			}
		}
		if( count( $arSqlOrder ) > 0 )
			$strSqlOrder = " ORDER BY " . implode( ", ", $arSqlOrder ) . " ";
		else
			$strSqlOrder = "";
		
		
		if( intval( $arNavi['COUNT'] ) > 0 ){
			$lim = " LIMIT " . intval( $arNavi['COUNT'] );
		}else{
			$lim = "";
		}
		$query = "SELECT * FROM  h_iblok_elements WHERE ( 1 = 1 ) " . $strSqlSearch . $strSqlOrder . $lim;	
		$arRes = $db->select($query);
		if( count( $arSelect ) ){		
			///////////////////////GetPropList
			foreach( $arRes as &$v ){
				$arPROR = array();
				foreach( $arSelect as $code ){					
					$arPROR[$code] = CProp::GetPropVal( $v['ID_IBLOCK'], $v['ID'], $code );
				}
				$v['PROP'] = $arPROR;
				unset( $v );
			}
		}			
		return $arRes;	
	}
	////////////////////////////////////////////
	function Add($arFields){
		global $db;	
		$res = false;
		$arRes = array();
		
		$arRes["NAME"] = trim(htmlspecialchars($arFields['NAME']));
		$arRes['ID_IBLOCK'] = intval($arFields['ID_IBLOCK']);		
		$resBlock = CIBlock::GetByID($arRes['ID_IBLOCK']);			
		
		if(strlen($arFields["NAME"])<1 || $resBlock["ID"] < 1){
			return false;			
		}
		if(!isset($arFields["ACTIVE"])){
			$arFields["ACTIVE"] = "N";
		}		
		if(!isset($arFields["SORT"])){
			$arFields["SORT"] = "500";
		}
		if(!isset($arFields["CODE"])){
			$arFields["CODE"] = CTools::translit($arFields["NAME"]);
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
					$arRes[$k] = $v;
				break;
				case "ACTIVE":
					if($v == "Y"){
						$arRes[$k] = "Y";
					}else{
						$arRes[$k] = "N";
					}
				break;
			}			
		}		
		$arRes["CREATE_DATE"] = time();
		$arRes["UP_DATE"] = time();
				
		$query = insert_db(
			"h_iblok_elements",
			$arRes			
		);		
		$res = $db->query($query);	
	
		return $res;		
	}
	////////////////////////////////////////
	function Update($ID, $arFields){
		global $db;
		$res = false;
		$IB = true;
		$ID = intval($ID);
		
		if(isset($arFields['ID_IBLOCK'])){
			$arRes['ID_IBLOCK'] = intval($arFields['ID_IBLOCK']);	
			$resBlock = CIBlock::GetByID($arRes['ID_IBLOCK']);
			if(intval($resBlock['ID']) < 1){
				$IB = false;
			}		
		}
		if($ID > 0 && $IB){
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
						$arRes["FIELD"][$k] = $v;
					break;
					case "NAME":				
						$arRes["FIELD"][$k] = trim(htmlspecialchars($v));
					break;
				}				
			}			
			$arRes["FIELD"]["UP_DATE"] = time();			
			$query = update_db(
				"h_iblok_elements",
				$arRes["FIELD"],
				$ID
			);			
			$res = $db->query($query);			
		}		
		return $res;		
	}
	////////////////////////////////////////////////
	public static function Delete($ID){
		global $db;		
		$ID = intval($ID);
		if($ID > 0){

			//////////////CFile::Delete($ID);
			$arFiles = array();
			$query = "
				SELECT
					h_prop_value.VALUE as ID_FILE
				FROM
					h_prop_value, (
						SELECT
							ID
						FROM
							h_prop_iblock,	(
								SELECT
									h_prop_type.ID as ID_TYPE
								FROM
									h_prop_type
								WHERE
										( 1 = 1 )
									AND	h_prop_type.TYPE = 'F'
							) as ID_TYPE
						WHERE
							h_prop_iblock.ID_PROP_TYPE = ID_TYPE.ID_TYPE
					) as ID_PROP	
				WHERE
						( 1 = 1 )
					AND	h_prop_value.ID_ELEMENT = '". $ID ."'
					AND ID_PROP.ID = h_prop_value.ID_PROP
				";
			$arFiles = $db->select( $query );
			foreach( $arFiles as $id_file ){			
				CFile::Delete( $id_file['ID_FILE'] );
			}			
			/////////////////////////////////
				
			$query = "DELETE FROM h_iblok_elements WHERE ID = ".$ID;
			$db->query($query);
			$query = "DELETE FROM h_prop_value WHERE ID_ELEMENT = ".$ID;
			$db->query($query);			
		}		
	}
}?>
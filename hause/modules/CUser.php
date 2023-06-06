<?if(!$B_PROLOG_M) die();?>
<?class CUser{
	/////////////MAIN////////
	function IsAuthorized(){
		$res = false;
		if($_SESSION["SESS_AUTH"]["AUTH"] == 'Y'){
			$res = true;
		}
		return $res;
	}
	function IsAdmin(){		
		$res = false;
		if($_SESSION["SESS_AUTH"]["ADMIN"] == 'Y'){
			$res = true;
		}		
		return $res;
	}
	function Login($login, $password){
		global $db;
		$res = false;
		$query = "SELECT * FROM h_users WHERE 1=1 and ACTIVE='Y' and LOGIN = '".$login."'";
		$arRes = $db->selectRow($query);		
		if( $arRes['PASS'] == md5( $password ) ){
			$res = true;
			$_SESSION["SESS_AUTH"]["ID"] = $arRes['ID'];
			$_SESSION["SESS_AUTH"]['NAME'] = $arRes['NAME'];
			$_SESSION["SESS_AUTH"]['LOGIN'] = $arRes['LOGIN'];
			$_SESSION["SESS_AUTH"]['EMAIL'] = $arRes['EMAIL'];
			$_SESSION['SESS_AUTH']['SHOT'] = 0;
			$_SESSION["SESS_AUTH"]["AUTH"] = 'Y';			
			$_SESSION["SESS_AUTH"]["GROUPS"] = CUser::GetUserGroup( $arRes['ID'] );			
			if( in_array( 1, $_SESSION["SESS_AUTH"]["GROUPS"] ) ){
				$_SESSION["SESS_AUTH"]["ADMIN"] = 'Y';
			}
		}
		return $res;
	}
	function Logout(){
		unset($_SESSION["SESS_AUTH"]);
	}
	function GetID(){
		$res = false;
		if( intval( $_SESSION["SESS_AUTH"]["ID"] ) ){
			$res = intval( $_SESSION["SESS_AUTH"]["ID"] );
		}
		return $res;
	}	
	//////////////GROOP/////////////
	public static function GetByGroopID($ID){
		global $db;
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_groops WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
		}
		return $res;
	}
	public static function GetListGroup($arOrder=Array("SORT"=>"ASC"), $arFilter=Array(),$count_el = 0){
		global $db;
		$strSqlSearch = "";
		foreach($arFilter as $key => $val){
			$res = CIBlock::MkOperationFilter($key);
			$key = strtoupper($res["FIELD"]);
			$cOperationType = $res["OPERATION"];
			switch($key){
				case "NAME":
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
				$by === "SORT"			||
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
		$query = "SELECT * FROM  h_groops WHERE 1=1 ".$strSqlSearch.$strSqlOrder.$lim;
		$arRes = $db->select($query);
		return $arRes;		
	}
	public static function GetGroupUser( $groopId ){
		global $db;
		$res = array();
		$query = "SELECT ID_USER FROM h_user_groop WHERE 1=1 and ID_GROOP = '".$groopId."'";
		$res = $db->select($query);
		array_walk( $res, function(&$val, $key){
			$val = $val['ID_USER'];
		});	
		return $res;
	}
	function AddGroup($arFields){
		global $db;	
		$res = false;
		if(strlen($arFields["NAME"])<1){
			return false;
		}
		if(!isset($arFields["SORT"])){
			$arFields["SORT"] = "500";
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
			"h_groops",
			$arRes
		);
		$res = $db->query($query);
		return $res;
	}
	function UpdateGroup( $ID, $arFields ){
		global $db;
		$res = false;
		$ID = intval( $ID );
		if( $ID ){
			$arRes = array(); 
			foreach($arFields as $k => $v){
				switch ($k){
					case "SORT":
						$v = intval($v);
						if($k == "SORT" && $v < 1)
							$v = 500;
						$arRes[$k] = $v;
					break;
					case "NAME":
					case "DESCRIPT_TEXT":
						if(strlen($v) > 0){
							$arRes[$k] = trim(htmlspecialchars($v));
						}
					break;
				}
			}
			$arRes["UP_DATE"] = time();
			$query = update_db(
				"h_groops",
				$arRes,
				$ID
			);
			$res = $db->query($query);
		}
		return $res;
	}
	public static function GroopDelete($ID){
		global $db;
		$ID = intval($ID);
		if($ID > 0){
			$res = CUser::GetGroupUser( $ID );
			if( !count( $res ) ){
				$query = "DELETE FROM h_groops WHERE ID = ".$ID;
				$db->query($query);
				$query = "DELETE FROM h_user_groop WHERE ID_GROOP = ".$ID;
				$db->query($query);
			}else{				
				return array(
					'RES' => 'ERR',
				);				
			}
		}		
	}	
	////////////USER///////////////
	public static function GetByID($ID){
		global $db;
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_users WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
			$res['ID_GROOP'] = CUser::GetUserGroup( $ID );
			
		}
		return $res;
	}	
	public static function GetListUser( $arOrder = Array( "SORT" => "ASC" ), $arFilter = Array(), $count_el = 0 ){
		global $db;
		$strSqlSearch = "";
		foreach($arFilter as $key => $val){
			$res = CIBlock::MkOperationFilter($key);
			$key = strtoupper($res["FIELD"]);
			$cOperationType = $res["OPERATION"];
			switch($key){				
				case "NAME":
				case "LOGIN":
				case "EMAIL":
					$sql = CIBlock::FilterCreate($key, $val, "string", $cOperationType);
				break;
				case "ID_GROOP":					
					$sql = CIBlock::FilterCreate("h_groops.ID", $val, "number", $cOperationType);
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
				$by === "LOGIN"			||
				$by === "EMAIL"			||
				$by === "SORT"			||
				$by === "CREATE_DATE"	||
				$by === "UP_DATE"					
			){
				$arSqlOrder[] = " " . $by . " " . $order;
			}
		}

		if(count($arSqlOrder) > 0)
			$strSqlOrder = " ORDER BY ".implode(", ", $arSqlOrder)." ";
		else
			$strSqlOrder = "";
		
		$strSqlGroup = " GROUP BY h_users.ID ";		
		if(intval($count_el) > 0){
			$lim = " LIMIT ".intval($count_el);
		}else{
			$lim = "";
		}	
		
		$query = "
		SELECT 	
			h_users.ID as ID,
			h_users.SORT as SORT,
			h_users.ACTIVE as ACTIVE,
			h_users.NAME as NAME,
			h_users.EMAIL as EMAIL,
			h_users.LOGIN as LOGIN,
			h_users.PASS as PASS,
			h_users.CREATE_DATE as CREATE_DATE,
			h_users.UP_DATE as UP_DATE,
			GROUP_CONCAT( h_groops.ID ) as ID_GROOP
		FROM  
			h_users,
			h_groops,
			h_user_groop
		WHERE 
			1=1			
			AND (h_users.ID = h_user_groop.ID_USER) 
			AND (h_groops.ID = h_user_groop.ID_GROOP)			
		"
		. $strSqlSearch
		. $strSqlGroup 
		. $strSqlOrder		
		. $lim;
		
		$arRes = $db->select($query);		
		foreach( $arRes as &$v ){
			if( strlen( $v['ID_GROOP'] ) ){
				$v['ID_GROOP'] = explode( ',', $v['ID_GROOP'] );
			}
		}
		unset($v);		
		return $arRes;		
	}	
	public static function GetUserGroup( $userId ){
		global $db;
		$res = array();
		$query = "SELECT ID_GROOP FROM h_user_groop WHERE 1=1 and ID_USER = '".$userId."'";
		$res = $db->select($query);		
		array_walk( $res, function(&$val, $key){
			$val = $val['ID_GROOP'];
		});		
		return $res;
	}	
	public static function SetUserGroup( $ID, $arPar ){
		global $db;	
		if( !count( $arPar ) ){
			return false;
		}
		if( !intval( $ID ) ){
			return false;
		}
		$ID = intval( $ID );
		
		$query = "DELETE FROM h_user_groop WHERE ID_USER = ".$ID;
		$db->query($query);
		
		foreach( $arPar as $v ){			
			if( !intval( $v ) )
				continue;			
			$ID_GROOP = intval( $v );			
			$query = insert_db(
				"h_user_groop",
				array(
					"ID_USER"	=> $ID,
					"ID_GROOP"	=> $ID_GROOP,
				)
			);			
			$db->query($query);
		}		
	}
	function AddUser($arFields){		
		global $db;	
		$res = false;		
		if(strlen($arFields["LOGIN"])<1){
			return false;
		}
		if(strlen($arFields["PASS"])<1){
			return false;
		}
		if(strlen($arFields["NAME"])<1){
			return false;
		}	

		
		if(!isset($arFields["SORT"])){
			$arFields["SORT"] = "500";
		}
		if(!isset($arFields["ACTIVE"])){
			$arFields["ACTIVE"] = "N";
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
				case "NAME":
				case "LOGIN":
					if(strlen($v) > 0){
						$arRes[$k] = trim(htmlspecialchars($v));
					}
				break;
				case "ACTIVE":				
					if($v == "Y"){
						$arRes[$k] = "Y";
					}else{
						$arRes[$k] = "N";
					}
				break;
				case "EMAIL":					
					if ( CTools::check_email( $v ) ){
						$arRes[$k] = $v;
					}else{
						$arRes[$k] = 'NON@NON.NON';
					}
				break;
				case "PASS":
					if(strlen($v) > 0){
						$arRes[$k] = md5( trim( htmlspecialchars( $v ) ) );
					}
				break;				
			}			
		}	
		$arRes["CREATE_DATE"] = time();
		$arRes["UP_DATE"] = time();		
		
		$query = insert_db(
			"h_users",
			$arRes			
		);		
		$res = $db->query($query);	
		return $res;	
	}
////////////////////////////////////////////////////////
	function UpdateUser($ID, $arFields){	
		global $db;	
		$res = false;		
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
				case "NAME":
				case "LOGIN":
					if(strlen($v) > 0){
						$arRes[$k] = trim(htmlspecialchars($v));
					}
				break;
				case "ACTIVE":				
					if($v == "Y"){
						$arRes[$k] = "Y";
					}else{
						$arRes[$k] = "N";
					}
				break;
				case "EMAIL":					
					if ( CTools::check_email( $v ) ){
						$arRes[$k] = $v;
					}else{
						$arRes[$k] = 'NON@NON.NON';
					}
				break;
				case "PASS":
					if(strlen($v) > 0){
						$arRes[$k] = md5( trim( htmlspecialchars( $v ) ) );
					}
				break;				
			}			
		}	
		$arRes["CREATE_DATE"] = time();
		$arRes["UP_DATE"] = time();		
		$query = update_db(
			"h_users",
			$arRes,
			$ID
		);
		$res = $db->query($query);	
		return $res;	
	}
////////////////////////////////////////////////////////	
	public static function UserDelete($ID){
		global $db;		
		$ID = intval($ID);
		if($ID > 0){
			$query = "DELETE FROM h_users WHERE ID = ".$ID;			
			$db->query($query);			
			$query = "DELETE FROM h_user_groop WHERE ID_USER = ".$ID;
			$db->query($query);			
		}		
	}
}
$USER = new CUser;
?>
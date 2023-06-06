<?php 
class DataBase {
	private static $db = null; // Единственный экземпляр класса, чтобы не создавать множество подключений
	private $mysqli;
	
	public static function getDB( $DBHOST, $DBUSER, $DBPASS, $DBNAME ) {			
		if (self::$db == null){
			self::$db = new DataBase( $DBHOST, $DBUSER, $DBPASS, $DBNAME );
		}
		return self::$db;
	}
	
	private function __construct( $DBHOST, $DBUSER, $DBPASS, $DBNAME ) {				
		$this->mysqli = new mysqli(
			$DBHOST,
			$DBUSER,
			$DBPASS,
			$DBNAME
		);		
		$this->mysqli->query("SET lc_time_names = 'ru_RU'");		
		$this->mysqli->query("SET NAMES 'utf8'");
		$this->mysqli->query("SET GLOBAL time_zone = '+03:00';");	
	}
	
	public function query( $query ) {		
		$arRes = array();
		$res = $this->mysqli->query( $query );
		if( $this->mysqli->errno ){
			$arRes = array(
				'TYPE'	=>	'ERR',
				'MESS'	=>	$this->mysqli->error,
			);
		}else{		
			$arRes = array(
				'TYPE'	=>	'OK',
				'COUNT'	=>	$res -> num_rows,
				'ITEM'	=>	$res,
			);		
		}
		return $arRes;
	}
	
	public function GetList(
		$strTable,
		$arSelect = array( '*' ),
		$arFilter = array( '1' => '1' ),
		$arSort = array('ID' => 'ASC' )		
	) {
		$query = 'SELECT {select} FROM {table} WHERE {filter} ORDER BY {sort}';
		
		$strSelect	=	implode( ', ' , $arSelect );
		$strFilter	=	'';
		$strSort	=	'';	
		
		/////////////////////////
		$temp = array();
		foreach( $arFilter as $k => $v ){
			$temp[] = $k." = \"".$v."\"";
		}
		$strFilter = implode(" AND ", $temp);
		///////////////////////////////////////////
		$temp = array();
		foreach( $arSort as $k => $v ){
			$temp[] = $k." = \"".$v."\"";
		}
		$strSort = implode(", ", $temp);	
		////////////////////////////////////
		
		$healthy = array(
			"{table}",
			"{select}",
			"{filter}",
			"{sort}",
		);
		$yummy = array(
			$strTable,
			$strSelect,
			$strFilter,
			$strSort,
		);		
		$query = str_replace( $healthy, $yummy, $query);	
		
		$res = $this->query( $query );		
		if ( $res['TYPE'] == 'ERR' ){
			return $res;
		}elseif( $res['TYPE'] == 'OK' ){			
			$array = array();
			while (($row = $res['ITEM']->fetch_assoc()) != false) {
				$array[] = $row;
			}			
			$res['ITEM'] = $array;
			return $res;
		}		
	}
	public function Add(
		$strTable,
		$arData			
	){		
		$query = "INSERT INTO {table} ( {key} ) VALUES ( {val} )";
		
		foreach($arData as &$v){
			$v = "\"".$v."\"";	
		}
		unset($v);
		
		$key = implode(" , ", array_keys  ($arData));
		$val = implode(" , ", array_values($arData));
		
		$healthy = array(
			"{table}",
			"{key}",
			"{val}",		
		);
		$yummy = array(
			$strTable,
			$key,
			$val,
		);	
		$query = str_replace($healthy, $yummy, $query);
		$res = $this->mysqli->query( $query );
		
		if ( $res ) {
			if ( $this->mysqli->insert_id === 0 ) 
				return array(
					'TYPE'	=>	'OK'
				);
			else 
				return array(
					'TYPE'	=>	'OK',
					'ID'	=>	$this->mysqli->insert_id,
				);
		}
		else 
			return array(
				'TYPE'	=>	'ERR'
			);	
	}
	
	public function Edit(
		$strTable,
		$arData,
		$arFilter		
	){
		$query = "UPDATE {table} SET {data} WHERE {filter} ";
		
		////////////////////////
		$temp = array();
		foreach($arData as $k => $v){
				$temp[] = $k." = \"".$v."\"";
		}
		$strData = implode(", ", $temp);
		
		///////////////////////////////
		$temp = array();
		foreach($arFilter as $k => $v){
			$temp[] = $k." = \"".$v."\"";		
		}
		$strFilter = implode(" AND ", $temp);		
		//////////////////////////////
			
		$healthy = array(
			"{table}",
			"{data}",
			"{filter}",
		);
		$yummy = array(
			$strTable,
			$strData,
			$strFilter,
		);	
		$query = str_replace($healthy, $yummy, $query);
		$res = $this->mysqli->query( $query );
		
		if ( $res ) {
			if ( $this->mysqli->insert_id === 0 ) 
				return array(
					'TYPE'	=>	'OK'
				);
		}
		else 
			return array(
				'TYPE'	=>	'ERR'
			);
	}
	
	public function __destruct() {
		if ($this->mysqli) 
			$this->mysqli->close();
	}
}

?>
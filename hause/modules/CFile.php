<?if(!$B_PROLOG_M) die();?>
<?
class CFile{
	public static function GetFilePach( $path ){
		$type = CFile::GetTypeFil_norm( $path );
		$name = md5( time() ) . '.' . $type;		
		$dir_add = "";
		$res = "";
		while(true){
			$dir_add = substr( md5( uniqid( "", true ) ), 0, 3 );
			if( !file_exists( $_SERVER["DOCUMENT_ROOT"] . "/upload/ib_block/" . $dir_add . "/" . $name ) ){
				$res = "/upload/ib_block/" . $dir_add . "/" . $name;
				mkdir( $_SERVER["DOCUMENT_ROOT"] . "/upload/ib_block/" . $dir_add . "/" );
				break;
			}		
		}		
		return $res;
	}
	////////////////////////
	public static function format_size($size){
		$metrics[0] = 'bytes';
		$metrics[1] = 'KB';
		$metrics[2] = 'MB';
		$metrics[3] = 'GB';
		$metrics[4] = 'TB';
		$metric = 0;
		while(floor($size/1024) > 0){
			++$metric;
			$size /= 1024;
		}
		$ret =  round($size,1)." ".(isset($metrics[$metric])?$metrics[$metric]:'??');
		return $ret;
	}
	/////////////////////
	public static function GetTypeFil_norm( $name ){
		$res = "";
		$nameA = explode( '.' , $name );
		$res = $nameA[count($nameA)-1];
		return $res;
	}
	///////////////////////	надо бы убрать
	public static function GetTypeFil_tyre($name){
		$res = "";
		$nameA = explode( '_' , $name );
		$res = $nameA[count($nameA)-1];
		return $res;
	}
	////////////////////////////
	public static function GetNameFil_path( $name ){
		$res = "";
		$nameA = explode('/',$name);
		$res = $nameA[count($nameA)-1];
		return $res;
	}	
	///////////////////////////////
	public static function MakeFileArray( $path, $mimetype = false ){
		$path = preg_replace("#(?<!:)[\\\\\\/]+#", "/", $path);
        if(strlen($path) == 0 || $path == "/"){
            return NULL;
        }
        if(preg_match("#^php://filter#i", $path)){
            return NULL;
        }	
		
		if(preg_match("#^(http[s]?)://#", $path)){			
			if( $fp = fopen( $path, "rb" ) ){
				$content = "";
				while(!feof($fp))
					$content .= fgets($fp, 4096);
				
				if( strlen( $content ) > 0){
					$ib_file_path = CFile::GetFilePach( $path );
					if ( CFile::RewriteFile( $_SERVER["DOCUMENT_ROOT"] . $ib_file_path, $content ) )
						$ID = CFile::MakeFileArray( $ib_file_path );
				}
                fclose($fp);
			 }
			return $ID;	
		}else{
            if( !file_exists( $path ) ){
                if ( file_exists( $_SERVER["DOCUMENT_ROOT"] . $path ) )
                    $path = $_SERVER["DOCUMENT_ROOT"] . $path;
                else
                    return NULL;
            }
			if( is_dir ( $path ) )
                return NULL;
			
			$arFile["NAME"] = str_replace( $_SERVER["DOCUMENT_ROOT"], "", $path );
			$arFile["SIZE"] = filesize( $path );
			$arFile["TYPE"] = $mimetype;
			$arFile["CREATE_DATE"] = time();
			
			if( strlen( $arFile["TYPE"] ) <= 0 ){
                $arFile["TYPE"] = CFile::GetTypeFil_norm( $path );
			}
		}
		
        if( strlen( $arFile["TYPE"] ) <=0 )
            $arFile["TYPE"] = "unknown";
		
		$arFile["TYPE"]	= strtolower( $arFile["TYPE"] );
		
		global $db;	
		$query = insert_db(
			"h_files",
			$arFile
		);
		$ID = $db->query($query);
		return $ID;
	}
	////////////////////////////////////////////
	public static function GetByID($ID){
		global $db;	
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_files WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
		}
		return $res;
	}
	////////////////////////////////////////////////////////////////////////
	public static function GetList(
		$arOrder = Array( "SORT" => "ASC" ),
		$arSelect = Array(),
		$arFilter = Array(),
		$arNavi = false
	){
		global $db;
		$strSqlSearch = "";
		
		foreach($arFilter as $key => $val){
			$res = CIBlock::MkOperationFilter($key);
			$key = strtoupper($res["FIELD"]);
			$cOperationType = $res["OPERATION"];
			switch($key){
				case "TYPE":
					$sql = CIBlock::FilterCreate($key, $val, "string", $cOperationType);
				break;
				case "CREATE_DATE":
				case "SIZE":
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
		foreach( $arOrder as $by => $order ){
			$by = strtoupper( $by );
			$order = strtoupper( $order ) == "ASC" ? "ASC" : "DESC";
			if(
				$by === "ID"			||
				$by === "NAME"			||
				$by === "SIZE"			||
				$by === "TYPE"			||
				$by === "CREATE_DATE"
				
			){
				$arSqlOrder[] = " " . $by . " " . $order;
			}
		}
		if( count( $arSqlOrder ) > 0 )
			$strSqlOrder = " ORDER BY " . implode( ", ", $arSqlOrder ) . " ";
		else
			$strSqlOrder = "";
		
		
		if( intval( $arNavi['COUNT'] ) > 0 ){
			$lim = " LIMIT " . intval( $arNavi['OFFSET'] ) . ',' . intval( $arNavi['COUNT'] );
		}else{
			$lim = "";
		}	
		$query = "SELECT * FROM  h_files WHERE ( 1 = 1 ) " . $strSqlSearch . $strSqlOrder . $lim;		
		$arRes = $db->select($query);
		return $arRes;
	}	
	//////////////////////////////////////////////////////////////////
	
	public static function Delete($ID){
		global $db;
		$ID = intval($ID);
		if($ID > 0){
			$res = CFile::GetByID( $ID );
			$path = $_SERVER["DOCUMENT_ROOT"] . $res['NAME'];
			unlink( $path );
			$name = CFile::GetNameFil_path( $path );
			rmdir( str_replace( $name, "", $path ) );
			$query = "DELETE FROM h_files WHERE ID = ".$ID;
			$db->query($query);
			
			$query = "
				SELECT
					ID
				FROM
					h_images
				WHERE
						1 = 1
					AND	ID_FILE = '" . $ID . "'
			";			
			$res = $db->select( $query );
			foreach( $res as $resizeImg ){
				CImage::Delete($resizeImg['ID']);
			}
		}
	}
	/////////////////
	public static function RewriteFile( $abs_path, $strContent ){
		$fd = fopen( $abs_path, "wb" );
		if( !fwrite( $fd, $strContent ) ) 
			return false; 
		fclose( $fd );
		return true;
	}	
	public static function RereadFile( $abs_path ){		
		$fd = fopen( $abs_path, "r" );
		$str = '';
		while( !feof( $fd ) ){
			$str .= fread( $fd, 600 );		
		}
		fclose( $fd );
		return $str;
	}	
}?>
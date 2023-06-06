<?if(!$B_PROLOG_M) die();?>
<?
class CImage{
	public static function GetByID($ID){
		global $db;	
		$res = false;
		$ID = intval($ID);
		if($ID > 0){
			$query = "SELECT * FROM h_images WHERE ID = '".$ID."'";
			$res = $db->selectRow($query);
		}
		return $res;
	}
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
				case "CREATE_DATE":
				case "SIZE":
				case "ID_FILE":
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
				$by === "ID_FILE"		||
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
		$query = "SELECT * FROM  h_images WHERE ( 1 = 1 ) " . $strSqlSearch . $strSqlOrder . $lim;		
		$arRes = $db->select($query);
		return $arRes;
	}	
	public static function ResizeImage( $ID, $SIZE ){
		global $db;
		$res = false;
		$ID = intval($ID);
		$SIZE = intval($SIZE);		
		if(
				$ID
			&&	$SIZE			
		){
			$query = "
				SELECT
					ID_FILE as ID,
					NAME	as SRC
				FROM
					h_images
				WHERE
						1 = 1
					AND	ID_FILE = '" . $ID . "'
					AND	SIZE = '" . $SIZE . "'
				
			";			
			$res = $db->selectRow( $query );
			if( intval( $res['ID'] ) ){
				return $res;
			}else{
				
				echo '<script>console.log(\'IMG\')</script>';
				
				$query = "
					SELECT
						*
					FROM
						h_files
					WHERE
							1 = 1
						AND	ID = '".$ID."'
				";			
				$res = $db->selectRow( $query );				
				$oregNAME =	$res['NAME'];				
				$uploadfile =  CFile::GetFilePach( basename( $oregNAME ) );
				if ( copy( $_SERVER["DOCUMENT_ROOT"] . $res['NAME'], $_SERVER["DOCUMENT_ROOT"] . $uploadfile ) ) {		
					$query = insert_db(
						"h_images",
						array(
							'ID_FILE'	=>	$ID,
							'SIZE'		=>	$SIZE,							
							'NAME'		=>	$uploadfile,						
						)
					);
					$res = array(
						'ID'		=>	$ID,
						'SRC'		=>	$uploadfile,
					);
					$ID = $db->query($query);
					/////////////////////////////////	
					$img = str_replace( '//', '/', $_SERVER["DOCUMENT_ROOT"] . $uploadfile );
					$im = new Imagick( $img );
					try{
						$arSize = CImage::GetImageSize( $uploadfile );
						if( $arSize['W'] < $arSize['H'] ){
							$im->resizeImage( $SIZE, 0, Imagick::FILTER_LANCZOS, 1 );							
						}else{
							$im->resizeImage( 0, $SIZE, Imagick::FILTER_LANCZOS, 1 );
						}						
						$im->writeImage( $img );
						$im->destroy();
						
					}catch (ImagickException $e){
						echo 'Imagick:ERROR:CImage 88';
					}					
					//////////////////////////////////////
				}
			}
		}
		return $res;
	}
	public static function GetImageSize($file){
		$res = array();
		list($res["W"], $res["H"]) = getimagesize( $_SERVER["DOCUMENT_ROOT"] . $file );
		return $res;
	}	
	public static function Delete( $ID ){		
		global $db;
		$ID = intval($ID);
		if($ID > 0){
			$res = CImage::GetByID( $ID );
			$path = $_SERVER["DOCUMENT_ROOT"] . $res['NAME'];
			unlink( $path );
			$name = CFile::GetNameFil_path( $path );
			rmdir( str_replace( $name, "", $path ) );
			$query = "DELETE FROM h_images WHERE ID = ".$ID;
			$db->query($query);
		}
	}	
}
?>
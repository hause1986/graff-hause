<?
/**class**/
class CMain{
	function IncludeFile( $file, $arParam = array() ){
		global $TOKYN;
		global $APPLICATION;
		global $USER;
		global $SITE;
		
		$path = $_SERVER["DOCUMENT_ROOT"] . $file;
		
		if( file_exists( $path ) ){
			ob_start();
			require( $path );					
			echo ob_get_clean();
		}else{
			echo "<div style=\"background-color: #fbe3e4;border: 1px solid #fbc2c4; color: #786510;display: block;padding: 5px;\">(".$file.") File not found</div>";
			return array();
		}
	}	
	function IncludeComponent( $name, $arParam = array(), $print = false ){	
		global $TOKYN;
		global $APPLICATION;
		global $USER;
		global $SITE;
	
		$name_compS = explode(":", $name);	
		$f_com = $_SERVER["DOCUMENT_ROOT"].'/hause/components/'.$name_compS[0].'/component/'.$name_compS[1].'.php';
		$f_tem = $_SERVER["DOCUMENT_ROOT"].'/hause/components/'.$name_compS[0].'/template/'.$name_compS[2].'.php';
		ob_start();		
		if((file_exists($f_com))&&(file_exists($f_tem))){			
			include $f_com;					
			include $f_tem;						
		}elseif((!file_exists($f_com))||(!file_exists($f_tem))){			
			echo "<div style=\"background-color: #fbe3e4;border: 1px solid #fbc2c4; color: #786510;display: block;padding: 5px;\">(".$name.") File not found</div>";
		}
		if($print){
			return ob_get_clean();
		}else{
			echo ob_get_clean();
		}		
	}
}
$APPLICATION = new CMain;
?>
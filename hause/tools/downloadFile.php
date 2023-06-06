<?require( $_SERVER["DOCUMENT_ROOT"]."/hause/core/init.php" );?>
<?
function file_force_download( $arFile ) {
	if ( file_exists( $arFile['NAME'] ) ) {
		if ( ob_get_level() ) {
			ob_end_clean();
		}		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . basename( $arFile['NAME_REAL'] ) );
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . $arFile['SIZE'] );
		
		if ( $fd = fopen( $arFile['NAME'], 'rb' ) ) {
			while ( !feof( $fd ) ) {
				echo fread( $fd, 1024 );
			}
			fclose( $fd );
		}
		die();
	}
}



$ID_FILE = intval( $_GET['id_file'] );
if( $ID_FILE ){
	$arFile = array();
	$arFile = CFile::GetByID( $ID_FILE );
	
	$arFile['NAME'] = $_SERVER["DOCUMENT_ROOT"] . '/' . $arFile['NAME'];	
	
	$arFile['NAME_REAL'] = str_replace(
		'_' . $arFile['TYPE'],
		'.' . $arFile['TYPE'],
		$arFile['NAME']
	);
	file_force_download( $arFile );
}
?>
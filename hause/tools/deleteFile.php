<?require( $_SERVER["DOCUMENT_ROOT"]."/hause/core/init.php" );?>
<?
$ID_FILE = intval( $_GET['id_file'] );
$ID_PROP_VALUE = intval( $_GET['id_prop_value'] );
$REDIRECT = $_SERVER['HTTP_REFERER'];
if(
		$ID_FILE
	&&	$ID_PROP_VALUE
){
	CFile::Delete( $ID_FILE );
	CProp::DeletePropVal( $ID_PROP_VALUE );
	if( strlen( $REDIRECT ) ){
		CTools::LocalRedirect( $REDIRECT );
	}
}?>
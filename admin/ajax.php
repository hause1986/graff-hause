<?require( $_SERVER["DOCUMENT_ROOT"]."/hause/core/init.php" );?>
<?
$arRes = array(
	'RES' => 'ERR',
);
if(
		$_POST['FORM_NAME'] == 'TRANSLITE'
	&&	strlen( $_POST['STR'] )
){
	$STR = '';
	$STR = CTools::translit( $_POST['STR'], array('change_case' => 'L' ) );	
	$arRes = array(
		'RES'	=>	'OK',
		'STR'	=>	$STR,
	);
}elseif( $_POST['FORM_NAME'] == 'CAPCHA_CODE' ){
	global $capt;
	$code = $capt->CaptchaGetCode();
	$arRes = array(
		'RES'	=>	'OK',
		'CODE'	=>	$code,
	);	
}
echo json_encode( $arRes );
?>
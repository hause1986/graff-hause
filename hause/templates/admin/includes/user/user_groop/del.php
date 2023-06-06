<?
global $arLINK;
$ID_GROOP = intval($_GET['id_groop']);
$arRes = CUser::GroopDelete( $ID_GROOP );
if( $arRes['RES'] == 'ERR' ){
	$arRes = array(	
		'PARAMS'	=>	array(
			'NAME'	=>	'У группы есть привязаные пользователи!',
		),		
		'BREAD'	=>	array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'		=>	'группы пользователей',
				'LINK'		=>	$arLINK['USERS_GROOP_LIST'],
			),
		),	
	);	
	$APPLICATION->IncludeFile(
		$SITE . '/includes/site/del.php',
		$arRes
	);
}else{
	CTools::LocalRedirect($arLINK['USERS_GROOP_LIST']);
}
?>
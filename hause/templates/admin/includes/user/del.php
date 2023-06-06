<?
global $arLINK;
$ID_USER = intval($_GET['id_user']);
$arRes = CUser::UserDelete( $ID_USER );
if( $arRes['RES'] == 'ERR' ){
	$arRes = array(	
		'PARAMS'	=>	array(
			'NAME'	=>	'Ошибка',
		),		
		'BREAD'	=>	array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'		=>	'Список пользователей',
				'LINK'		=>	$arLINK['USER_LIST'],
			),
		),	
	);	
	$APPLICATION->IncludeFile(
		$SITE . '/includes/site/del.php',
		$arRes
	);
}else{
	CTools::LocalRedirect($arLINK['USER_LIST']);
}
?>
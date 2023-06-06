<?
global $arLINK;
$ID_IBLOCK = intval($_GET['id_iblock']);
$arRes = CIBlock::Delete( $ID_IBLOCK );
if( $arRes['RES'] == 'ERR' ){
	$arRes = array(	
		'PARAMS'	=>	array(
			'NAME'	=>	'Не удалось удалить ИБ',
		),		
		'BREAD'	=>	array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'		=>	'Список ИнфоБлоков',
				'LINK'		=>	$arLINK['IBLOCK_LIST'],
			),
		),	
	);	
	$APPLICATION->IncludeFile(
		$SITE . '/includes/site/del.php',
		$arRes
	);
}else{
	CTools::LocalRedirect($arLINK['IBLOCK_LIST']);
}
?>
<?
global $arLINK;
$ID = intval($_GET['id']);
$arRes = CProp::PropDelete( $ID );
if( $arRes['RES'] == 'ERR' ){
	$arRes = array(	
		'PARAMS'	=>	array(
			'NAME'	=>	'Не удалось удалить Доп. свойство',
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
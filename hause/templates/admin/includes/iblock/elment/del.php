<?
global $arLINK;

$ID_ELMENT = intval($_GET['id_elment']);
$elm = new CIBlockElement();

$arElement = $elm->GetByID( $ID_ELMENT );
$ID_IBLOCK = intval( $arElement['ID_IBLOCK'] );

$urlELMENT_LIST = str_replace(
	'#ID#',
	$ID_IBLOCK,
	$arLINK['ELMENT_LIST']
);

$arRes = $elm->Delete( $ID_ELMENT );
if( $arRes['RES'] == 'ERR' ){
	$arRes = array(	
		'PARAMS'	=>	array(
			'NAME'	=>	'Не удалось удалить Элемент',
		),		
		'BREAD'	=>	array(
			array(
				'VALUE'	=>	'Меню',
				'LINK'	=>	$arLINK['MAIN'],
			),
			array(
				'VALUE'		=>	'Список Элементов',
				'LINK'		=>	$urlELMENT_LIST,
			),
		),	
	);	
	$APPLICATION->IncludeFile(
		$SITE . '/includes/site/del.php',
		$arRes
	);
}else{
	CTools::LocalRedirect($urlELMENT_LIST);
}
?>
<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
$ID_IBLOCK = intval($arParam['ID_IBLOCK']);
$arRes = CProp::GetPropList(
	array(),
	array(	
		'ID_IBLOCK'	=>	$ID_IBLOCK,
	)
);

$arParam['FIELD'] = array(
	array(
		'CODE'	=>	'ID',
		'NAME'	=>	'ID',
	),
	array(
		'CODE'		=>	'CODE',
		'NAME'		=>	'Код',
	),			
	array(
		'CODE'		=>	'NAME',
		'NAME'		=>	'Название',		
	),
	array(
		'CODE'		=>	'TYPE',
		'NAME'		=>	'Тип',			//ID_PROP_TYPE
	),
	array(
		'CODE'	=>	'ACTIVE',
		'NAME'	=>	'Акт.',
	),
	array(
		'CODE'	=>	'MULTIPLE',
		'NAME'	=>	'Множ.',
	),
	array(
		'CODE'	=>	'FLAG',
		'NAME'	=>	'Флаг',
	),	
	array(
		'CODE'	=>	'REQUIRED',
		'NAME'	=>	'Обяз.',
	),
	array(
		'CODE'	=>	'SORT',
		'NAME'	=>	'Сорт.',
	),
);
foreach( $arRes as $v ){
	$ITEM = array();
	foreach( $arParam['FIELD'] as $FIELD ){	
		unset( $FIELD['TYPE'] );
	
		$CODE = $FIELD['CODE'];
		$TYPE = $FIELD['TYPE'];
		$VALUE = $v[$CODE];
		$ITEM[ $CODE ] = $VALUE;
		
	}
	$URL_EDIT	= str_replace(
		'#ID#',
		$v['ID'],
		$arParam['EDIT_ELM']
	);
	$URL_DEL	= str_replace(
		'#ID#',
		$v['ID'],
		$arParam['DEL_ELM']
	);
	$ITEM['URL_EDIT'] = $URL_EDIT;
	$ITEM['URL_DEL'] = $URL_DEL;	
	
	$arParam['ITEMS'][] = $ITEM;	
}
?>
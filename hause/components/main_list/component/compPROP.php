<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
$arRes = CProp::GetList();
$arParam['FIELD'] = array(
	array(
		'CODE'	=>	'ID',
		'NAME'	=>	'ID',
	),		
	array(
		'CODE'	=>	'NAME',
		'NAME'	=>	'Название',
	),
	array(
		'CODE'	=>	'TYPE',
		'NAME'	=>	'Символьное обожначение кода',
	),
);
foreach( $arRes as $v ){
	$ITEM = array();	
	foreach( $arParam['FIELD'] as $FIELD ){	
		
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



















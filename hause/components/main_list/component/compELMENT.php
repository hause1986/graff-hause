<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
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
		'CODE'	=>	'CODE',
		'NAME'	=>	'Символьный код',
	),
	array(
		'CODE'	=>	'SORT',
		'NAME'	=>	'Сорт',
	),
	array(
		'CODE'	=>	'ACTIVE',
		'NAME'	=>	'Актив',
	),
	array(
		'CODE'	=>	'CREATE_DATE',
		'NAME'	=>	'Дата создания',
		'TYPE'	=>	'D',
	),
	array(
		'CODE'	=>	'UP_DATE',
		'NAME'	=>	'Дата изменения',
		'TYPE'	=>	'D',
	),
);
$ID_IBLOCK = intval( $arParam['ID_IBLOCK'] );
$arRes = CIBlockElement::GetList(
	array(),
	array(),
	array(
		'ID_IBLOCK' => $ID_IBLOCK
	)
);
foreach( $arRes as $v ){
	$ITEM = array();	
	foreach( $arParam['FIELD'] as $FIELD ){		
		$CODE = $FIELD['CODE'];
		$TYPE = $FIELD['TYPE'];		
		$VALUE = $v[$CODE];		
		if( $TYPE == 'D' ){
			$VALUE = CTools::FormatDate('d.m.Y H:i', $VALUE);
		}elseif( $TYPE == 'L' ){
			$VALUE = implode(' / ', $VALUE);
		}		
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
<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
$arRes = CIBlock::GetList();
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
	$URL_LIST_ELM	= str_replace(
		'#ID#',
		$v['ID'],
		$arParam['LIST_ELM']
	);	
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
	$URL_PROP_MOD	= str_replace(
		array(
			'#ID_IBLOCK#',
			'#ID_MOD#'
		),
		array(
			$v['ID'],
			'2'
		),
		$arParam['PROP_MOD']
	);
	
	$ITEM['URL_PROP_MOD'] = $URL_PROP_MOD;
	$ITEM['URL_LIST_ELM'] = $URL_LIST_ELM;
	$ITEM['URL_EDIT'] = $URL_EDIT;
	$ITEM['URL_DEL'] = $URL_DEL;
	
	$arParam['ITEMS'][] = $ITEM;
}
?>



















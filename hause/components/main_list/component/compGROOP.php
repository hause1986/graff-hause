<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
$arRes = $USER->GetListGroup();
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
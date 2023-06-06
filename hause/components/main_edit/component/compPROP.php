<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
$ID_PROP = intval( $arParam['ID_PROP'] );
$arPROP = CProp::GetByID( $ID_PROP );

$arParam['FIELD'] = array(
	array(
		'CODE'		=>	'NAME',
		'NAME'		=>	'Название',
		'TYPE'		=>	'S',
		'REQUIRED'	=>	'Y',
	),
	array(
		'CODE'		=>	'TYPE',
		'NAME'		=>	'Символьное обожначение кода',
		'TYPE'		=>	'S',
		'REQUIRED'	=>	'Y',				
	),
);

if( $arPROP['ID'] == $ID_PROP ){	
	foreach( $arParam['FIELD'] as &$v ){
		if( $v['TYPE'] == 'H' ){
			continue;
		}
		$value = $arPROP[$v['CODE']];
		$v['VALUE'] = $value;		
	}
	unset( $v );	
}else{
	$arParam['ERR'] = 'Элемент не найден!';
}
if( $_POST['FORM_NAME'] == $arParam['FORM_NAME'] ){
	$flag = true;
	
	$arFields = array();
	foreach( $arParam['FIELD'] as &$filds ){		
		$value = $_POST[$filds['CODE']];
		$key = $filds['CODE'];
		$type = $filds['TYPE'];
		/////////////////////////////////////////

		if( $filds['REQUIRED'] == 'Y' ){
			if( !strlen( $value ) ){
				$flag = false;
				continue;
			}
		}
		
		////////////////////**///////////		
		if( $filds['VALUE'] != $value ){
			$arFields[$key] = $value;
			$filds['VALUE'] = $value;
		}
	}
	unset($filds);
	if( $flag && count( $arFields ) ){
		$prop =	new CProp();
		$prop->Update($ID_PROP , $arFields );
	}
	if( $ID ){
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
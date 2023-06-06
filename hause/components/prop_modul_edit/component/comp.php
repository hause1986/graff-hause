<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
function formatArr( $arPar ){
	$arRes = array();	
	foreach( $arPar as $key => $val ){
		foreach( $val as $k => $v ){
			$arRes[$k][$key] = $v;
		}
	}	
	return $arRes;
}
function list_prop_type(){
	$arRes = array();
	$arPar = CProp::GetList();
	
	foreach( $arPar as $v ){
		$arRes[] = array(
			'ID'	=>	$v['ID'],
			'NAME'	=>	$v['NAME'],
		);
	}	
	return $arRes;	
}
$ID = intval( $arParam['ID'] );
$arRes = CProp::GetPropByID( $ID );


$arParam['FIELD'] = array(
	array(
		'CODE'		=>	'ID_IBLOCK',
		'NAME'		=>	'Привязка к ИБ',
		'TYPE'		=>	'H',
		'REQUIRED'	=>	'Y',		
	),			
	array(
		'CODE'		=>	'NAME',
		'NAME'		=>	'Название',
		'TYPE'		=>	'S',
		'REQUIRED'	=>	'Y',
	),
	array(
		'CODE'		=>	'CODE',
		'NAME'		=>	'Символьное обожначение',
		'TYPE'		=>	'S',
		'REQUIRED'	=>	'Y',				
	),
	array(
		'CODE'		=>	'ID_PROP_TYPE',
		'NAME'		=>	'Тип Свойства',			//ID_PROP_TYPE
		'TYPE'		=>	'L',				
	),
	array(
		'CODE'		=>	'ITEMS',
		'NAME'		=>	'Значения списка свойств',
		'ITEMS'		=>	CProp::GetPropEnum( $ID ),
	),	
	array(
		'CODE'	=>	'FLAG',
		'NAME'	=>	'Внешний вид списка Флаг',
		'TYPE'	=>	'L',
		'MULTIPLE'	=>	'Y',
		'FLAG'	=>	'Y',
		'ITEMS'		=>	array(
			array(
				'ID'	=>	'Y',
				'NAME'	=>	'Да',
			),
		),		
	),
	array(
		'CODE'	=>	'ACTIVE',
		'NAME'	=>	'Активен',
		'TYPE'	=>	'L',
		'MULTIPLE'	=>	'Y',
		'FLAG'	=>	'Y',
		'ITEMS'		=>	array(
			array(
				'ID'	=>	'Y',
				'NAME'	=>	'Да',
			),
		),		
	),
	array(
		'CODE'	=>	'MULTIPLE',
		'NAME'	=>	'Множественное (несколько вариантов)',
		'TYPE'	=>	'L',
		'MULTIPLE'	=>	'Y',
		'FLAG'	=>	'Y',
		'ITEMS'		=>	array(
			array(
				'ID'	=>	'Y',
				'NAME'	=>	'Да',
			),
		),		
	),			
	array(
		'CODE'	=>	'REQUIRED',
		'NAME'	=>	'Обязательное',
		'TYPE'	=>	'L',
		'MULTIPLE'	=>	'Y',
		'FLAG'	=>	'Y',
		'ITEMS'		=>	array(
			array(
				'ID'	=>	'Y',
				'NAME'	=>	'Да',
			),
		),		
	),			
	array(
		'CODE'	=>	'SORT',
		'NAME'	=>	'Сорт.',
		'TYPE'	=>	'S',		
	),			
);

if( $arRes['ID'] == $ID ){	
	foreach( $arParam['FIELD'] as &$v ){
		$value = $arRes[$v['CODE']];

		if( $v['CODE'] == 'ID_PROP_TYPE' ){
			$v['ITEMS'] = list_prop_type();
		}		
		$v['VALUE'] = $value;		
	}
	unset( $v );
	
}else{
	$arParam['ERR'] = 'Элемент не найден!';
}

if( $_POST['FORM_NAME'] == $arParam['FORM_NAME'] ){
	$flag = true;
	$arItems = array();
	$arFields = array();
	foreach( $arParam['FIELD'] as $filds ){		
		$value = $_POST[$filds['CODE']];
		$key = $filds['CODE'];
		$type = $filds['TYPE'];	
		
		if( $key == 'ITEMS' ){
			continue;
		}
		
		/////////////////////////////////////////		
		if( $type == 'L' ){
			if( $filds['REQUIRED'] == 'Y' ){
				if( !count( $value ) ){
						$flag = false;
						continue;
					}
			}
		}else{
			if( $filds['REQUIRED'] == 'Y' ){
				if( !strlen( $value ) ){
					$flag = false;
					continue;
				}
			}else{
				if( !strlen( $value ) ){
					continue;
				}
			}
		}		
		////////////////////**///////////		
		$arFields[$key] = $value;
	}	
	if( $flag ){
		$elm = new CProp();
		$elm->UpdatePropMod( $ID, $arFields );
		
		if( $arFields['ID_PROP_TYPE'] == '3' ){
			$arItems = formatArr( $_POST['ITEMS'] );
			foreach( $arItems as $v ){
				if( intval( $v['ID'] ) ){
					if( !strval( $v['VALUE'] ) ){
						$elm->DeletePropEnum( $v['ID'] );
					}else{
						$elm->UpdatePropEnum( $v['ID'], $v );
					}
				}else{
					$elm->AddPropEnum( $ID, $v );
				}
			}		
		}		
	}
	if( $ID ){		
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
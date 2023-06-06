<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
function StrKeyNon( $array ){
	foreach( $array as $k => $v ){
		if( !strlen( $v ) ){
			unset($array[$k]);
		}
	}
	return $array;
}
$arParam['FIELD'] = array(
	array(
		'CODE'		=>	'ID_IBLOCK',
		'NAME'		=>	'Привязка к инфоблоку',
		'TYPE'		=>	'H',
		'REQUIRED'	=>	'Y',
		'VALUE'		=>	$arParam['ID_IBLOCK'],
	),		
	array(
		'CODE'		=>	'NAME',
		'NAME'		=>	'Название',
		'TYPE'		=>	'S',
		'REQUIRED'	=>	'Y',
	),
	array(
		'CODE'		=>	'CODE',
		'NAME'		=>	'Символьный код',
		'TYPE'		=>	'S',				
	),				
	array(
		'CODE'	=>	'SORT',
		'NAME'	=>	'Сортировка',
		'VALUE'	=>	'500',
		'TYPE'	=>	'I',
	),
	array(
		'CODE'		=>	'ACTIVE',
		'NAME'		=>	'Активен',
		'TYPE'		=>	'L',
		'FLAG'		=>	'Y',
		'MULTIPLE'	=>	'Y',
		'ITEMS'		=>	array(
			array(
				'ID'	=>	'Y',
				'NAME'	=>	'Да',
			),
		),
		'VALUE'	=>	'Y',
	),		
);
$arPROP = CProp::GetPropList(
	array(
		"SORT"	=>	"ASC"
	),
	array(		
		'ID_IBLOCK'	=>	$arParam['ID_IBLOCK'],
		'ACTIVE'	=>	'Y',
	)
);
foreach( $arPROP as $v ){
	$arITEMS = array();
	$ITEMS = array();
	$TYPE = CProp::GetByID( $v['ID_PROP_TYPE'] );
	if( $TYPE['TYPE'] == 'L' ){		
		$arITEMS = CProp::GetPropEnum( $v['ID'] );
		foreach( $arITEMS as $enum ){			
			$ITEMS[] = array(
				'ID'	=>	strlen( $enum['CODE'] ) ? $enum['CODE'] : $enum['ID'],
				'NAME'	=>	$enum['VALUE'],
			);
		}
	}	
	$arParam['PROP'][] = array(
		'CODE'		=>	$v['CODE'],
		'NAME'		=>	$v['NAME'],
		'TYPE'		=>	$TYPE['TYPE'],
		'FLAG'		=>	$v['FLAG'],
		'MULTIPLE'	=>	$v['MULTIPLE'],
		'ITEMS'		=>	$ITEMS,	
	);
}

if( $_POST['FORM_NAME'] == $arParam['FORM_NAME'] ){
	$flag = true;
	////////////////////////// основные поля
	$arFields = array();
	foreach( $arParam['FIELD'] as $filds ){		
		$value = $_POST[$filds['CODE']];
		$key = $filds['CODE'];
		$type = $filds['TYPE'];
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
	////////////////////////////////доп.поля
	$arProps = array();
	foreach( $arParam['PROP'] as $prop ){		
		$value = $_POST[$prop['CODE']];
		$key = $prop['CODE'];
		$type = $prop['TYPE'];
		/////////////////////////////////////////

		if( $prop['REQUIRED'] == 'Y' ){
			if( $prop['MULTIPLE'] == 'Y' ){				
				$value = StrKeyNon($value);
				if( !count( $value ) ){
					$flag = false;
					continue;
				}
			}else{
				if( !strlen( $value ) ){
					$flag = false;
					continue;
				}
			}
		}else{
			if( $prop['MULTIPLE'] == 'Y' ){
				$value = StrKeyNon($value);
				if( !count( $value ) ){
					continue;
				}
			}else{
				if( !strlen( $value ) ){
					continue;
				}
			}
		}
		
		////////////////////**///////////		
		$arProps[$key] = $value;
	}
	/////////для файлов
	foreach( $arParam['PROP'] as $prop ){
		if( $prop['TYPE'] != 'F' ){
			continue;
		}
		$CODE = $prop['CODE'];		
		if( $prop['MULTIPLE'] == 'Y' ){		
			$FILES = CTools::diverse_array( $_FILES[$CODE] );			
			foreach( $FILES as $file ){
				//////////////////////////
				if( intval( $file['size'] ) >0 ){
					$uploadfile = $_SERVER["DOCUMENT_ROOT"] . CFile::GetFilePach( $file['name'] );
					if ( move_uploaded_file( $file['tmp_name'], $uploadfile ) ) {
						$arProps[$CODE][] = CFile::MakeFileArray( $uploadfile );
					}
				}
				/////////////////////////
			}
		}else{		
			//////////////////////////
			if( intval( $_FILES[$CODE]['size'] ) > 0 ){
				$uploadfile = $_SERVER["DOCUMENT_ROOT"] . CFile::GetFilePach( $_FILES[$CODE]['name'] );
				if ( move_uploaded_file( $_FILES[$CODE]['tmp_name'], $uploadfile ) ) {
					$arProps[$CODE] = CFile::MakeFileArray( $uploadfile );
				}
			}
			/////////////////////////
		}
	}
	if( $flag ){
		$elm = new CIBlockElement();
		$ID = $elm->Add( $arFields );
		foreach( $arProps as $key => $Prop ){
			CProp::SetPropVal( $arParam['ID_IBLOCK'], $ID, $key, $Prop );
		}
	}
	if( $ID ){		
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
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

$ID_ELMENT = intval( $arParam['ID_ELMENT'] );
$arELMENT = CIBlockElement::GetByID( $ID_ELMENT );

if( $arELMENT['ID'] == $ID_ELMENT ){
	$arParam['FIELD'] = array(
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
	foreach( $arParam['FIELD'] as &$v ){
		if( $v['TYPE'] == 'H' ){
			continue;
		}
		$value = $arELMENT[$v['CODE']];		
		$v['VALUE'] = $value;		
	}
	unset( $v );
	foreach( $arELMENT['PROP'] as &$v ){
		$ITEMS = array();		
		if( $v['TYPE'] == 'L' ){			
			$ITEMS = CProp::GetPropEnum( $v['ID'] );
			foreach( $ITEMS as $item ){
				$v['ITEMS'][] = array(
					'ID'	=>	strlen( $item['CODE'] ) ? $item['CODE'] : $item['ID'],
					'NAME'	=>	$item['VALUE'],	
					'VALUE'	=>	$item['CODE'] == $v['VALUE'] ? $v['VALUE'] : '',
				);
			}
		}elseif( $v['TYPE'] == 'F' ){			
			if( $v['MULTIPLE'] == 'Y' ){				
				$value = array();		
				foreach( $v['VALUE'] as $key => $valFile ){
					$value[] = array(
						'ID'		=>	$valFile,
						'CODE'		=>	$v['CODE'],
						'LINK'		=>	str_replace(
							'#ID_FILE#',
							$valFile,
							$arParam['FILE_DOWNLOAD']
						),
						'LINK_DEL'	=>	str_replace(
							array(
								'#ID_FILE#',
								'#ID_PROP_VALUE#',
							),
							array(
								$valFile,
								$v['ID_PROP_VALUE'][$key],
							),
							$arParam['FILE_DELETE']
						),
					);
				}
				$v['VALUE'] = $value;				
			}else{
				$v['VALUE'] = array(
					'ID'		=>	$v['VALUE'],
					'CODE'		=>	$v['CODE'],
					'LINK'		=>	str_replace(
						'#ID_FILE#',
						$v['VALUE'],
						$arParam['FILE_DOWNLOAD']
					),
					'LINK_DEL'	=>	str_replace(
						array(
							'#ID_FILE#',
							'#ID_PROP_VALUE#',							
						),
						array(
							$v['VALUE'],
							$v['ID_PROP_VALUE'],
						),
						$arParam['FILE_DELETE']
					),
				);	
			}
			unset($v['ID_PROP_VALUE']);
		}	
	}
	unset( $v );	
	$arParam['PROP'] = $arELMENT['PROP'];	
}else{
	$arParam['ERR'] = 'Элемент не найден!';
}

if( $_POST['FORM_NAME'] == $arParam['FORM_NAME'] ){
	$flag = true;
	
	//////////////////////////////////////////все хорошо
	$arFields = array();
	foreach( $arParam['FIELD'] as &$filds ){		
		$value = $_POST[$filds['CODE']];
		$key = $filds['CODE'];
		$type = $filds['TYPE'];
		
		if( $type == 'L' ){
			// такова варианта у нас тут нет
		}else{
			if( $filds['REQUIRED'] == 'Y' ){
				if( !strlen( $value ) ){
					$flag = false;
					continue;
				}
			}
		}		
		if( $filds['VALUE'] != $value ){
			$arFields[$key] = $value;
			$filds['VALUE'] = $value;
		}
	}
	unset($filds);
	//////////////////////////////////////////////	
	$arProps = array();	
	foreach( $arParam['PROP'] as &$prop ){
		if( $prop['TYPE'] == 'F' ){
			continue;
		}		
		$key = $prop['CODE'];
		$type = $prop['TYPE'];		
		$value = $_POST[$prop['CODE']];
		
		if( $prop['REQUIRED'] == 'Y' ){
			if( $prop['MULTIPLE'] == 'Y' ){
				if( !count( $value ) ){
					$flag = true;
				}
			}else{
				if( !strlen( $value ) ){
					$flag = true;
				}
			}
		}		
		if( $prop['MULTIPLE'] == 'Y' ){			
			$diff1 = array_diff( $prop['VALUE'], $value );
			$diff2 = array_diff( $value , $prop['VALUE'] );
		
			if( count( $diff1 ) || count( $diff2 ) ){
				$arProps[$key] = $value;
				$prop['VALUE'] = $value;				
			}
		}else{			
			if( $prop['VALUE'] != $value ){				
				$arProps[$key] = $value;
				$prop['VALUE'] = $value;
			}
		}
		////////////////////**///////////		
	}
	unset($prop);	
	/////////для файлов
	foreach( $arParam['PROP'] as $prop ){
		if( $prop['TYPE'] != 'F' ){
			continue;
		}
		$CODE = $prop['CODE'];		
		if( $prop['MULTIPLE'] == 'Y' ){		
			$FILES = CTools::diverse_array( $_FILES[$CODE] );			
			foreach( $FILES as $file ){				
				if( intval( $file['size'] ) >0 ){
					$uploadfile = $_SERVER["DOCUMENT_ROOT"] . CFile::GetFilePach( $file['name'] );
					if ( move_uploaded_file( $file['tmp_name'], $uploadfile ) ) {
						$arProps[$CODE][] = CFile::MakeFileArray( $uploadfile );
					}
				}				
			}
		}else{			
			if( intval( $_FILES[$CODE]['size'] ) > 0 ){
				$uploadfile = $_SERVER["DOCUMENT_ROOT"] . CFile::GetFilePach( $_FILES[$CODE]['name'] );
				if ( move_uploaded_file( $_FILES[$CODE]['tmp_name'], $uploadfile ) ) {
					$arProps[$CODE] = CFile::MakeFileArray( $uploadfile );
				}
			}			
		}
	}	
	if( $flag ){		
		if( count( $arFields ) ){
			$elm = new CIBlockElement();
			$elm->Update($ID_ELMENT , $arFields );
		}
		if( count( $arProps ) ){
			foreach( $arProps as $key => $prop ){			
				CProp::SetPropVal( $arELMENT['ID_IBLOCK'], $ID_ELMENT, $key, $prop );
			}
		}		
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();		
	}	
}?>
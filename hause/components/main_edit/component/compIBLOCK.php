<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?

$ID_IBLOCK = intval( $arParam['ID_IBLOCK'] );
$arIBLOCK = CIBlock::GetByID( $ID_IBLOCK );
if( $arIBLOCK['ID'] == $ID_IBLOCK ){
	
	foreach( $arParam['FIELD'] as &$v ){
		if( $v['TYPE'] == 'H' ){
			continue;
		}
		$value = $arIBLOCK[$v['CODE']];		
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
		if( $type == 'L' ){
			
		}else{
			if( $filds['REQUIRED'] == 'Y' ){
				if( !strlen( $value ) ){
					$flag = false;
					continue;
				}
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
		$id_block = new CIBlock();
		$id_block->Update($ID_IBLOCK , $arFields );
	}
	if( $ID ){
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
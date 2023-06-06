<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
function list_groop(){
	$arRes = array();
	$arPar = CUser::GetListGroup();
	
	foreach( $arPar as $v ){
		$arRes[] = array(
			'ID'	=>	$v['ID'],
			'NAME'	=>	$v['NAME'],
		);
	}	
	return $arRes;	
}

foreach( $arParam['FIELD'] as &$v ){
	if( $v['CODE'] == 'NAME_GROOP' ){
		$v['ITEMS'] = list_groop();
		break;
	}else{
		continue;
	}
}
unset($v);

if( $_POST['FORM_NAME'] == $arParam['FORM_NAME'] ){
	$flag = true;
	
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
	if( $flag ){
		$ID = $USER->AddUser( $arFields );		
	}
	if( $ID ){
		CUser::SetUserGroup( $ID , $_POST['NAME_GROOP'] );
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
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
$ID_USER = intval( $arParam['ID_USER'] );
$arUSER = $USER->GetByID( $ID_USER );
if( $arUSER['ID'] == $ID_USER ){	
	foreach( $arParam['FIELD'] as &$v ){		
		if( $v['CODE'] == 'ID_GROOP' ){
			$v['ITEMS'] = list_groop();
		}		
		if( $v['TYPE'] == 'H' ){
			continue;
		}		
		if( $v['TYPE'] == 'P' ){
			$value = '';
		}else{			
			$value = $arUSER[$v['CODE']];
		}		
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
		//////////////////////////////////////////
		if( $key == 'ID_GROOP' ){
			if(
					count( $value )
				&&	$filds['VALUE'] != $value
			){
				$filds['VALUE'] = $value;
				CUser::SetUserGroup( $ID_USER , $value );
			}
			continue;
		}
		/////////////////////////////////////////
		if( $type == 'L' ){
			
		}else{
			if( $filds['REQUIRED'] == 'Y' ){				
				if( !strlen( $value ) ){
					$flag = false;
					continue;
				}				
			}
			if(		$type == 'P'
				&&	strlen( $value )
				&&	md5( $value ) != $filds['VALUE']
			){				
				$arFields[$key] = $value;
				$filds['VALUE'] = $value;				
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
		$USER->UpdateUser( $ID_USER , $arFields );
	}
	if( $ID ){
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
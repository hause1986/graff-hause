<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
$ID_GROOP = intval( $arParam['ID_GROOP'] );
$arGroop = CUser::GetByGroopID( $ID_GROOP );

if( $arGroop['ID'] == $ID_GROOP ){	
	foreach( $arParam['FIELD'] as &$v ){
		if( $v['TYPE'] == 'H' ){
			continue;
		}
		$value = $arGroop[$v['CODE']];
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
		$USER->UpdateGroup($ID_GROOP , $arFields );
	}
	if( $ID ){
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
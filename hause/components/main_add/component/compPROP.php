<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?
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
		////////////////////**/////////
		$arFields[$key] = $value;
	}	
	if( $flag ){
		$pror = new CProp();
		$ID = $pror->Add($arFields);
	}
	if( $ID ){
		CTools::LocalRedirect( $arParam['REDIRECT_URL'] );
		die();
	}
}?>
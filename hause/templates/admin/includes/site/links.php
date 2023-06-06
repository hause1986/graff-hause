<?
$main_link = 'admin';
$arPar = array();
$arPar['MAIN'] = array(
	'',
	$main_link,
	'',
);
$arPar['LOGOUT'] = array(
	'',
	$main_link,
	'?logout=yes',
);





/**/
$arPar['USER_LIST'] = array(
	'',
	$main_link,
	'user_list',
	'',
);
$arPar['USER_ADD'] = array(
	'',
	$main_link,
	'user_add',
	'',
);
$arPar['USER_EDIT'] = array(
	'',
	$main_link,
	'user_edit',
	'?id_user=#ID#',
);
$arPar['USER_DEL'] = array(
	'',
	$main_link,
	'user_del',
	'?id_user=#ID#',
);





/**/
$arPar['USERS_GROOP_LIST'] = array(
	'',
	$main_link,
	'user_groop_list',
	'',
);
$arPar['USERS_GROOP_ADD'] = array(
	'',
	$main_link,
	'user_groop_add',
	'',
);
$arPar['USERS_GROOP_EDIT'] = array(
	'',
	$main_link,
	'user_groop_edit',
	'?id_groop=#ID#',	
);
$arPar['USERS_GROOP_DEL'] = array(
	'',
	$main_link,
	'user_groop_del',
	'?id_groop=#ID#',	
);





/**/
$arPar['IBLOCK_LIST'] = array(
	'',
	$main_link,
	'iblock_list',
	'',
);
$arPar['IBLOCK_ADD'] = array(
	'',
	$main_link,
	'iblock_add',
	'',
);
$arPar['IBLOCK_EDIT'] = array(
	'',
	$main_link,
	'iblock_edit',
	'?id_iblock=#ID#',
);
$arPar['IBLOCK_DEL'] = array(
	'',
	$main_link,
	'iblock_del',
	'?id_iblock=#ID#',
);





/**/
$arPar['ELMENT_LIST'] = array(
	'',
	$main_link,
	'elment_list',
	'?id_iblock=#ID#',
);
$arPar['ELMENT_ADD'] = array(
	'',
	$main_link,
	'elment_add',
	'?id_iblock=#ID#',
);
$arPar['ELMENT_EDIT'] = array(
	'',
	$main_link,
	'elment_edit',
	'?id_elment=#ID#',
);
$arPar['ELMENT_DEL'] = array(
	'',
	$main_link,
	'elment_del',
	'?id_elment=#ID#',
);





/**/
$arPar['PROP_LIST'] = array(
	'',
	$main_link,
	'prop_list',
	'',
);
$arPar['PROP_ADD'] = array(
	'',
	$main_link,
	'prop_add',
	'',
);
$arPar['PROP_EDIT'] = array(
	'',
	$main_link,
	'prop_edit',
	'?id_prop_type=#ID#',
);
$arPar['PROP_DEL'] = array(
	'',
	$main_link,
	'prop_del',
	'?id_prop_type=#ID#',
);
/////////////////удалять всее связки!!!

$arPar['PROP_MOD'] = array(
	'',
	$main_link,
	'prop_mod',
	'?id_iblock=#ID_IBLOCK#',
);
$arPar['PROP_MOD_ADD'] = array(
	'',
	$main_link,
	'prop_mod_add',
	'?id_iblock=#ID_IBLOCK#',
);
$arPar['PROP_MOD_EDIT'] = array(
	'',
	$main_link,
	'prop_mod_edit',
	'?id=#ID#',	
);
$arPar['PROP_MOD_DEL'] = array(
	'',
	$main_link,
	'prop_mod_del',
	'?id=#ID#',	
);

///////////для файлов/////////////////////////
$options = array(
	'id_file' => '#ID_FILE#',
);
$arPar['FILE_DOWNLOAD'] = array(
	'',
	'hause',
	'tools',
	'downloadFile.php?' . urldecode(
		http_build_query( $options )
	),	
);
unset( $options );


$options = array(
	'id_file'		=>	'#ID_FILE#',
	'id_prop_value'	=>	'#ID_PROP_VALUE#',
);
$arPar['FILE_DELETE'] = array(
	'',
	'hause',
	'tools',
	'deleteFile.php?' . urldecode(
		http_build_query( $options )
	),	
);
unset( $options );
/////////////////для кучи доп страниц///////////////////////
$arPar['PHP_INFO'] = array(
	'',
	$main_link,
	'php_info',
	'',
);
$arPar['FILE_SEARCH'] = array(
	'',
	$main_link,
	'file_search',
	'',	
);
$arPar['WEBVISOR'] = array(
	'',
	$main_link,
	'webvisor',
	'',	
);
/////////////////////////////////////////////////////////
global $arLINK;
foreach( $arPar as $key => $val ){
	$arLINK[$key] = implode( '/', $val );
}	
?>
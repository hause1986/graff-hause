<?
function routerAdmin( $Par, $GET ){
	$arRes = array();
	$arPar = explode( '?', $Par );	
	$arParDir = explode( '/', $arPar[0] );	
	foreach( $arParDir as $v ){
		if( !strlen( $v ) ){
			continue;
		}
		$arRes['DIR'][] = $v;
	}
	if( strlen( $arPar[1] ) ){
		$arRes['PARAM'] = $GET;
	}
	return $arRes;
}
$GLOBALS['SETTING']['TITLE'] = 'Админка';
$APPLICATION->IncludeComponent(
	"system_auth:comp:temp_admin",
	array(
		'CAPTCHA' => 'Y',
	)
);
if($USER->IsAdmin()){	
	$arDir = routerAdmin( $_SERVER['REQUEST_URI'], $_GET );
	
	/*пользователи*/
	if( $arDir['DIR'][1] == 'user_list' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/list.php' );
	}elseif( $arDir['DIR'][1] == 'user_add' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/add.php' );
	}elseif(
			$arDir['DIR'][1] == 'user_edit'
		&&	intval( $arDir['PARAM']['id_user'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/edit.php' );
	}elseif(
			$arDir['DIR'][1] == 'user_del'
		&&	intval( $arDir['PARAM']['id_user'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/del.php' );		
		
	/*группы пользователей*/
	}elseif( $arDir['DIR'][1] == 'user_groop_list' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/user_groop/list.php' );
	}elseif( $arDir['DIR'][1] == 'user_groop_add' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/user_groop/add.php' );			
	}elseif(
			$arDir['DIR'][1] == 'user_groop_edit'
		&&	intval( $arDir['PARAM']['id_groop'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/user_groop/edit.php' );
	}elseif(
			$arDir['DIR'][1] == 'user_groop_del'
		&&	intval( $arDir['PARAM']['id_groop'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/user/user_groop/del.php' );	
		
	/*инфоблоки*/
	}elseif( $arDir['DIR'][1] == 'iblock_list' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/list.php' );
	}elseif( $arDir['DIR'][1] == 'iblock_add' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/add.php' );			
	}elseif(
			$arDir['DIR'][1] == 'iblock_edit'
		&&	intval( $arDir['PARAM']['id_iblock'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/edit.php' );
	}elseif(
			$arDir['DIR'][1] == 'iblock_del'
		&&	intval( $arDir['PARAM']['id_iblock'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/del.php' );
		
	/*элементы ИБ*/
	}elseif(
			$arDir['DIR'][1] == 'elment_list'
		&&	intval( $arDir['PARAM']['id_iblock'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/elment/list.php' );
	}elseif( $arDir['DIR'][1] == 'elment_add' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/elment/add.php' );			
	}elseif(
			$arDir['DIR'][1] == 'elment_edit'
		&&	intval( $arDir['PARAM']['id_elment'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/elment/edit.php' );
	}elseif(
			$arDir['DIR'][1] == 'elment_del'
		&&	intval( $arDir['PARAM']['id_elment'] )
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/iblock/elment/del.php' );
		
		/*Дополнительные свойства*/
	}elseif( $arDir['DIR'][1] == 'prop_list' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/prop/list.php' );
	}elseif( $arDir['DIR'][1] == 'prop_add' ){
		$APPLICATION->IncludeFile( $SITE . '/includes/prop/add.php' );
	}elseif(
			$arDir['DIR'][1] == 'prop_edit'
		&&	intval( $arDir['PARAM']['id_prop_type'] )
	){		
		$APPLICATION->IncludeFile( $SITE . '/includes/prop/edit.php' );
		
		////Дополнительные свойства у модулей		
	}elseif( $arDir['DIR'][1] == 'prop_mod' ){		
		$APPLICATION->IncludeFile( $SITE . '/includes/prop/prop_mod/list.php' );
	}elseif( $arDir['DIR'][1] == 'prop_mod_add'){
		$APPLICATION->IncludeFile( $SITE . '/includes/prop/prop_mod/add.php' );
	}elseif(
			$arDir['DIR'][1] == 'prop_mod_edit'
		&&	intval( $arDir['PARAM']['id'] )		
	){	
		$APPLICATION->IncludeFile( $SITE . '/includes/prop/prop_mod/edit.php' );
	}elseif(
			$arDir['DIR'][1] == 'prop_mod_del'
		&&	intval( $arDir['PARAM']['id'] )	
	){
		$APPLICATION->IncludeFile( $SITE . '/includes/prop/prop_mod/del.php' );		
	}elseif(
		$arDir['DIR'][1] == 'php_info'
	){		
		$APPLICATION->IncludeFile( $SITE . '/includes/setting/php_info.php' );
	}elseif(
		$arDir['DIR'][1] == 'file_search'
	){		
		$APPLICATION->IncludeFile( $SITE . '/includes/setting/file_search.php' );	
	}elseif(
		$arDir['DIR'][1] == 'webvisor'
	){		
		$APPLICATION->IncludeFile( $SITE . '/includes/setting/webvisor.php' );		
	/*все остальное*/			
	}else{	
		// главная страница
		$APPLICATION->IncludeFile( $SITE . '/includes/site/left_blok.php' );
		$APPLICATION->IncludeFile( $SITE . '/includes/site/right_blok.php' );
	}	
}
?>
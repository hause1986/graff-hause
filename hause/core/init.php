<?/*разные пхп функции и определение шаблона*/?>
<?
header("Content-Type: text/html; charset=utf-8");
//error_reporting (E_ALL);
if (version_compare(phpversion(), '5.1.0', '<') == true)  die ('PHP5.1 Only');
global $B_PROLOG_M;
$B_PROLOG_M = true;
session_start();
$TOKYN = md5( '19821714hausee' . session_id() );

/***db*****/
require($_SERVER["DOCUMENT_ROOT"].'/hause/core/db/dbconfig.php');
require($_SERVER["DOCUMENT_ROOT"].'/hause/core/db/mysql.php');
$db = DataBase::getDB();
/***/

/*moduli*/
$arRes["modules"][] = "CMain";
$arRes["modules"][] = "new_db";
$arRes["modules"][] = "CIBlock";
$arRes["modules"][] = "CIBlockElement";
$arRes["modules"][] = "CProp";
$arRes["modules"][] = "CFile";
$arRes["modules"][] = "CImage";
$arRes["modules"][] = "CUser";
$arRes["modules"][] = "CCaptcha";
$arRes["modules"][] = "CTools";

foreach($arRes["modules"] as $v){
	$modules = $_SERVER["DOCUMENT_ROOT"].'/hause/modules/'.$v.'.php';
	if(file_exists($modules)){		
		include $modules;			
	}	
}
/**/
$_POST = CTools::arrUTF($_POST);
$_GET = CTools::arrUTF($_GET);


if( 
		isset( $_GET['logout'] )
	&&	( $_GET['logout'] == 'yes' )
){
	$USER->Logout();
	$arUrl = explode( '?' , $_SERVER['REQUEST_URI'] );	
	CTools::LocalRedirect( $arUrl[0] );
}
/////////////////////// установка заголовка 
function ShowTitle(){
	echo "{TITLE}";
}
//////////////////////////////////
function ShowH1(){
	echo "{TITLE_H1}";
}
ob_start();
?>
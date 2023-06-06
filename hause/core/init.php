<?/*разные пхп функции и определение шаблона*/?>
<?
header('Content-Type: text/html; charset=utf-8');
//error_reporting (E_ALL);
if (version_compare(phpversion(), '5.1.0', '<') == true)  die ('PHP5.1 Only');
global $B_PROLOG_M;
$B_PROLOG_M = true;
session_start();
$TOKYN = md5( '19821714hausee' . session_id() );

/*moduli*/
$arRes['modules'][] = 'CMain';
$arRes['modules'][] = 'CTools';

foreach($arRes['modules'] as $v){
	$modules = $_SERVER['DOCUMENT_ROOT'] . '/hause/modules/' . $v . '.php';
	if(file_exists($modules)){		
		include $modules;			
	}	
}
/**/
$_POST = CTools::arrUTF( $_POST );
$_GET = CTools::arrUTF( $_GET );

/////////////////////// установка заголовка 
function ShowTitle(){
	echo '{TITLE}';
}
//////////////////////////////////
function ShowH1(){
	echo '{TITLE_H1}';
}
ob_start();
?>
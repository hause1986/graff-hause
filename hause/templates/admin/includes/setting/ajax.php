<?
function is_type_f($name){
	global $arPar;
	
	$res = false;
	$nameA = explode('.',$name);
	$typ = $nameA[count($nameA)-1];
	if( in_array( $typ, $arPar["TYPE_FIL"] ) ){
		$res = true;
	}
	return $res;
}
function scan_fil($file){
	global $arPar;
	$arRes = array();	
	$content = file_get_contents($file);	
	foreach( $arPar["SCAN"] as $v){
		$pos = strpos($content, $v);
		if($pos > 0){
			$arRes = $v;
		}
	}	
	return $arRes;
}
function obrabotchik($arr){
	$arRes = array();
	$dir = $_SERVER['DOCUMENT_ROOT'];	
	foreach($arr as $entry){		
		$items = scan_fil( $dir.$entry );
		if(count($items)>0){
			
			$arRes[] = "<pre>".print_r(
				array(					
					"LINK" => $entry,
					"SIZE" => filesize($dir.$entry),
					"LASTMOD" => date("d.m.Y H:i:s", filemtime($dir.$entry)),
					"ITEMS"	=> $items,
				)
			, true)."</pre>";
		}		
	}
	return $arRes;
}
///////////////////////////////////////////////
function getFileList( $dir, $fpL ){
	global $arPar;
	
	if(substr($dir, -1) != "/") 
		$dir .= "/";		
	$d = @dir($dir);
	
	while(false !== ($entry = $d->read())){
		if($entry[0] == ".") 
			continue;
		if(is_dir($dir.$entry)) {			
			if(is_readable($dir.$entry."/")) {
				getFileList($dir.$entry."/", $fpL);				
			}
		}elseif(is_readable($dir.$entry)) {
			if( !is_type_f( $entry ) )
				continue;			
			$patch = str_replace($_SERVER['DOCUMENT_ROOT'], "/", $dir.$entry)."\n";			
			fwrite( $fpL, $patch );		
		}
	}
	$d->close();	
}
/////////////////////////////////////////////
$arPar['PACH'] = array(
	'LIST_FILES' =>   $_SERVER['DOCUMENT_ROOT'] . '/hause/templates/admin/includes/setting/list_files.txt',
);
if( count( $_POST['SEARCH'] ) ){
	$arPar["SCAN"] = $_POST['SEARCH'];
}
if( count( $_POST['TYPE_FIL'] ) ){
	$arPar["TYPE_FIL"] = $_POST['TYPE_FIL'];
}

if( $_POST['STATUS'] == 'START' ){
	if( !file_exists( $arPar['PACH']['LIST_FILES'] ) ){
		$fpL = fopen( $arPar['PACH']['LIST_FILES'], "w" );
		$dir = $_SERVER['DOCUMENT_ROOT'];		
		getFileList($dir, $fpL);
		fclose($fpL);
	}	
	//получаю размеры файлов
	if(intval($_POST["MAX"])){
		$MAX = intval( $_POST["MAX"] );
	}else{
		$MAX = filesize( $arPar['PACH']['LIST_FILES'] );
	}
	
	$fpI = fopen( $arPar['PACH']['LIST_FILES'], "r");
	//Получаю на коком месте сейчас установлен курсор в файле
	
	if( intval( $_POST["SEEK"] ) ){
		fseek( $fpI, intval( $_POST["SEEK"] ), SEEK_SET );
		$SEEK = intval ( $_POST["SEEK"] );		
	}else{
		$SEEK = 0;		
	}	
	
	//беру несколько строк из fpI файла для обработки
	$strNom = 0;
	while(!feof($fpI)){		
		if( $strNom < $_POST['STEP'] ) {	
			$line =  trim(fgets( $fpI, 9999 ));
			$arRes['LIST'][] = $line;
			$strNom++;
		}else{
			break;			
		}		
		$SEEK = ftell($fpI);
	}	
	fclose($fpI);
	/////////////////////////////////
	$arRes['RES'] = obrabotchik( $arRes['LIST'] );
	/////////////////////////////////

	if( $MAX > $SEEK && $_POST['STATUS'] == 'START'){
		$arRes['STATUS'] = 'START';
		$arRes['STEP'] = $_POST['STEP'];
		$arRes['SEEK'] = $SEEK;
		$arRes['MAX'] = $MAX;
		$arRes['PROSESS'] = round( ($SEEK * 100 ) / $MAX);
	}else{
		$arRes['STATUS'] = 'END';
		$arRes['PROSESS'] = '100';
		
		@unlink( $arPar['PACH']['LIST_FILES'] );
	}
}
echo json_encode($arRes);
?>
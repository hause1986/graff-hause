<?if(file_exists($SITE_1."/footer.php")){
	require($SITE_1."/footer.php");
}else{
	echo "<div class='MessErrore'>Ошибка: templates '".$templ."' не найден!</div>";
 	die();
}?>
<?$content = ob_get_clean();

$content = preg_replace("!{TITLE}!", $GLOBALS['SETTING']['TITLE'], $content);
$content = preg_replace("!{TITLE_H1}!", $GLOBALS['SETTING']['H1'], $content);
echo $content;
?>
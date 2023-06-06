<?require( $_SERVER["DOCUMENT_ROOT"]."/hause/core/init.php" );?>
<?
$new_db = new new_db();
$new_db->Delete();
$new_db->Add();
?>
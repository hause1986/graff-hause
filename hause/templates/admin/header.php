<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title><?ShowTitle();?></title>	
		<?$GLOBALS['SETTING']['TITLE'] = 'Hause'?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />		
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="<?=$SITE?>/css/style.css" />		
		<link rel="stylesheet" href="<?=$SITE?>/css/template.css" />
		<link rel="stylesheet" href="<?=$SITE?>/css/media.css" />
		<link rel="shortcut icon" href="/favicon.ico" />		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		
		<script src='<?=$SITE?>/js/htmlViwer/htmlViwer.js'></script>
		<link href='<?=$SITE?>/js/htmlViwer/htmlViwer.css' rel="stylesheet" />
		
		<script src="<?=$SITE?>/js/script.js"></script>
	</head>
	<body>		
		<div class='container'>		
			<div class='row'>
				<div class='dis_flex' id='top_line'>
					<div class="logo">
						<div class="main_text_logo">hause</div>
						<div class="sub_text_logo">graff</div>
					</div>
					<?if( $USER->IsAdmin() ){?>	
						<?
						$arLINK = array();
						$APPLICATION->IncludeFile( $SITE . '/includes/site/links.php' );
						global $arLINK;
						?>
						<div class='profile'>
							<div><a href='<?=$arLINK['LOGOUT']?>' title='Выход'><?=$_SESSION['SESS_AUTH']['NAME']?></a></div>
							<div><a href='<?=$arLINK['LOGOUT']?>' title='Выход'><?=$_SESSION['SESS_AUTH']['LOGIN']?></a></div>
							<div><a href='<?=$arLINK['LOGOUT']?>' title='Выход'><?=$_SESSION['SESS_AUTH']['EMAIL']?></a></div>
						</div>
					<?}?>
				</div>
			</div>						
			<div class='row'>
				<div class='col-md' id='content'>					
					<div class='row'>	
						<div class='col-md main_block'>
							<div class='row main_page'>
								<!-- -->
<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?$DIR = str_replace( $_SERVER['DOCUMENT_ROOT'], '/', __DIR__ );?>
<?if(!$USER->IsAuthorized()){?>	
	<link rel="stylesheet" href="<?=$DIR?>/style.css" />
	<script src="<?=$DIR?>/script.js"></script>
	<div id="auth_form_mod">			
		<form method = "POST" name="">
			<div class='fild h1'>Авторизуйтесь</div>
			<div class='fild'>
				<input type="hidden" name="AUTH_F" value="Y">
			</div>
			<div class='fild'>
				<input type="text" name="LOGIN" class="text" placeholder="Login" value=""/>
			</div>
			<div class='fild'>
				<input type="password" name="PASS" class = "text" placeholder="PassWord"  value="" />
			</div>
			<?if($arParam['CAPTCHA']== "Y"){?>
				<div class='fild row' data-captcha>
					<div data-captcha-sid class="captcha col-md" style="background-image: url('/hause/tools/captcha.php?captcha_sid=<?=$code?>');">
						<input type="hidden" name="captcha_sid" value="<?=$code;?>" />
					</div>
					<div class="captcha_find col-md">
						<input class="text" placeholder="Captcha" type="text" name="captcha_word" value="" />
					</div>
					<div class='butt captcha_update col-md'>
						<a href="#" data-captcha-update>&#8634;</a>
					</div>
				</div>						
			<?}?>
			<div class='fild'>
				<input type="submit" class="submit" value= "ENTER">
			</div>
		</form>		
	</div>
<?}?>
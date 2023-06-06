<?
global $arLINK;
$arRes = array();
$arRes['ID_USER'][] = array(
	"CLASS"	=> "list_user",
	"NAME"	=> "Список пользователей",
	"URL"	=>	$arLINK['USER_LIST'],
);
$arRes['ID_USER'][] = array(
	"CLASS"	=> "list_groop",	
	"NAME"	=> "Группы пользователей",
	"URL"	=>	$arLINK['USERS_GROOP_LIST'],
);
?>
<ul class="vertikal_list_tree user">
	<li class='main_li'>
		<div class="user_li is_pr_y parentsLi">
			<span class="ico_is"></span>
			<span class="ico_typ infoL"></span>
			<span class='infoL'>Пользователи</span>
		</div>
		<?if(count($arRes['ID_USER'])>0){?>
			<ul class="flow">
				<?foreach($arRes['ID_USER'] as $arItem){?>
					<li>
						<div class="is_pr_n parentsLi <?=$arItem["CLASS"]?>" data-href="<?=$arItem["URL"]?>">
							<span class="ico_is"></span>
							<span class="ico_typ infoL"></span>
							<span class='infoL'><?=$arItem["NAME"]?></span>
						</div>
					</li>
				<?}?>
			</ul>
		<?}?>
	</li>
</ul>
<?
global $arLINK;
$arRes = array();
/*
$ID_IBlock = CIBlock::GetList(
	array(),
	array()
);
foreach($ID_IBlock as $ib_v){
	$arRes['ID_BLOCK'][] = array(
		"ID"	=> $ib_v['ID'],
		"NAME"	=> $ib_v['NAME'],
		"URL"	=> str_replace(
			'#ID#',
			$ib_v['ID'],
			$arLINK['ELMENT_LIST']
		),
	);
}*/
?>
<ul class="vertikal_list_tree iblock">
	<li class='main_li'>
		<div class="db_li is_pr_y parentsLi"> 
			<span class="ico_is"></span>
			<span class="ico_typ infoL"></span>
			<span class='infoL'>ИнфоБлоки</span>
		</div>
		<ul class="flow">
			<li>
				<div class="is_pr_n parentsLi add_li" data-href="<?=$arLINK['IBLOCK_ADD']?>">
					<span class="ico_is"></span>
					<span class="ico_typ infoL"></span>
					<span class='infoL'>Создать</span>
				</div>
			</li>
			<li>
				<div class="is_pr_n parentsLi list_li" data-href="<?=$arLINK['IBLOCK_LIST']?>">
					<span class="ico_is"></span>
					<span class="ico_typ infoL"></span>
					<span class='infoL'>Список</span>
				</div>
			</li>				
			<?if( count( $arRes['ID_BLOCK'] ) >0 ){?>
				<?foreach( $arRes['ID_BLOCK'] as $arItem ){?>
					<li>
						<div class="is_pr_n parentsLi iblok_li" data-href="<?=$arItem["URL"]?>">						
							<span class="ico_is"></span>
							<span class="ico_typ infoL"></span>
							<span class='infoL'><?=$arItem["NAME"]?></span>
						</div>
					</li>
				<?}?>
			<?}?>
		</ul>
	</li>
</ul>
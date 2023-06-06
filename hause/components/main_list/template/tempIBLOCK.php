<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?$DIR = str_replace( $_SERVER['DOCUMENT_ROOT'], '/', __DIR__ );?>
<link rel="stylesheet" href="<?=$DIR?>/styleIBLOCK.css" />
<div class='fild table'>
	<div class='thead'>
		<div class='dis_flex tr'>
			<?foreach( $arParam['FIELD'] as $td){?>
				<?
				$class = mb_strtolower( $td['CODE'] );
				$VALUE = $td['NAME'];
				?>
				<div class='td <?=$class?>' title='<?=$VALUE?>'><?=$VALUE?></div>
			<?}?>
			<div class='dis_flex td control'>
				<div class='td edit' title='Редактировать'></div>
				<div class='td delet' title='Удалить'></div>
			</div>
		</div>
	</div>
	<div class='tbody'>
		<?foreach($arParam['ITEMS'] as $tr){?>
			<div class='dis_flex tr'>
				<?foreach( $arParam['FIELD'] as $td){?>
					<?	
					$VALUE = $tr[$td['CODE']];
					$class = mb_strtolower( $td['CODE'] );
					?>
					<div class='td <?=$class?>' title='<?=$VALUE?>'><?=$VALUE?></div>
				<?}?>
				<div class='dis_flex td control'>					
					<a class='td list' href='<?=$tr['URL_LIST_ELM']?>' title='Список элементов'>&#9776;</a>
					<a class='td setting' href='<?=$tr['URL_PROP_MOD']?>' title='Список Доп. полей'>&#8251;</a>
					<a class='td edit' href='<?=$tr['URL_EDIT']?>' title='Редактировать'>&#9998;</a>					
					<a class='td delet' href='<?=$tr['URL_DEL']?>' title='Удалить'>&#10006;</a>
				</div>
			</div>
		<?}?>	
	</div>	
</div>


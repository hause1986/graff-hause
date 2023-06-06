<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
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
					<a class='td edit' href='<?=$tr['URL_EDIT']?>' title='Редактировать'>&#9998;</a>
					<a class='td delet' href='<?=$tr['URL_DEL']?>' title='Удалить'>&#10006;</a>
				</div>
			</div>
		<?}?>	
	</div>	
</div>


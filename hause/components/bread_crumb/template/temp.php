<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?if( count( $arParam['ITEMS'] ) ){?>
	<div class='fild'>
		<div class='bread_crumb'>
			<?$i = 0;?>
			<?foreach( $arParam['ITEMS'] as $v ){?>
				<?if( intval( $i ) ){?>
					<span class='arr'>></span>
				<?}?>
				<a href='<?=$v['LINK']?>' title='<?=$v['VALUE']?>'><?=$v['VALUE']?></a>
				<?$i ++?>
			<?}?>
		</div>
	</div>
<?}?>
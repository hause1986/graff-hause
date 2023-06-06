<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<div class='fild table'>
	<div class='tbody'>
		<?foreach( $arParam['LIST'] as $v ){?>
			<div class='dis_flex tr'>
				<div class='td name'><?=$v['NAME']?></div>
				<div class='td quanty'><?=$v['QUANTY']?></div>
			</div>
		<?}?>
	</div>
</div>
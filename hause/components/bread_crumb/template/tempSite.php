<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>
<?if( count( $arParam['ITEMS'] ) ){?>
	<style>
	.bread_crumb{		
		margin-top:16px;
		margin-bottom:40px;
	}
	.bread_crumb{
		color: #737373;
	}
	.bread_crumb a{
		padding: 10px 1px;
		font-size:14px;
		color:#333;
		text-decoration:underline;
	}
	</style>
	<div class='container'>
		<div class='bread_crumb'>
			<?$i = 0;?>
			<?foreach( $arParam['ITEMS'] as $v ){?>
				<?if( intval( $i ) ){?>
					<span class='arr'> / </span>
				<?}?>
				<?if( strlen( $v['LINK'] ) ){?>
					<a href='<?=$v['LINK']?>' title='<?=$v['VALUE']?>'><?=$v['VALUE']?></a>
				<?}else{?>
					<?=$v['VALUE']?>
				<?}?>
				<?$i ++?>
			<?}?>
		</div>
	</div>
<?}?>
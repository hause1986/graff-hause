<?global $B_PROLOG_M?>
<?if(!$B_PROLOG_M) die();?>

<?
function printField( $arPar ){?>
	<?foreach( $arPar as $v ){?>
		<?
		$REQUIRED = ( $v['REQUIRED'] == 'Y' ) ? 'data-req' : '';
		$VALUE = strlen( $v['VALUE'] ) ? $v['VALUE'] : '';
		?>	
		<div class='fild'>
			<div class='label'>
				<?=$v['NAME']?>
				<?if( $REQUIRED == 'data-req' ){?>
					<span class='req'>*</span>
				<?}?>				
			</div>
			<?if( $v['TYPE'] == 'H' ){?>
				<input
					type='hidden'
					name='<?=$v['CODE']?>'
					value='<?=$VALUE?>'	>
			<?}elseif( $v['TYPE'] == 'T' ){?>
				<?if( $v['MULTIPLE'] == 'Y' ){?>
					<?foreach( $v['VALUE'] as $key => $item ){?>
						<div class='list_prop_enum'>
							<div class='dis_flex fild'>
								<div class='htmlViwer'>
									<textarea 
										class='text'
										name='<?=$v['CODE']?>[ID_<?=$v['ID_PROP_VALUE'][$key]?>]'
										<?=$REQUIRED?>	><?=$item?></textarea>
								</div>
							</div>
						</div>
					<?}?>				
					<div class='list_prop_enum' data-multiple>
						<div class='dis_flex fild' data-multiple-clone>
							<div class='htmlViwer'>
								<textarea 
									class='text'
									name='<?=$v['CODE']?>[]'
									<?=$REQUIRED?>	><?=$VALUE?></textarea>
							</div>
						</div>
						<div class='fild'>
							<div class="butt min-butt">
								<a href="#" data-multiple-sudmit>Ещё</a>
							</div>
						</div>
					</div>
				<?}else{?>
					<div class='htmlViwer'>
						<textarea 
							class='text'
							name='<?=$v['CODE']?>'
							<?=$REQUIRED?>	><?=$VALUE?></textarea>
					</div>
				<?}?>
			<?}elseif( $v['TYPE'] == 'L' ){?>			
				<?if( $v['FLAG'] == 'Y' ){?>
					<?if( $v['MULTIPLE'] == 'Y' ){?>
						<div class='dis_flex_left'>
							<?foreach( $v['ITEMS'] as $list ){?>
								<div class='dis_flex'>
									<input
										name="<?=$v['CODE']?>"
										type="checkbox"
										<?=(  $list['ID'] == $v['VALUE']  ? 'checked' : '' )?>
										value="<?=$list['ID']?>">
									<div class='label'><?=$list['NAME']?></div>
								</div>
							<?}?>
						</div>
					<?}else{?>
						<div class='dis_flex_left'>
							<?foreach( $v['ITEMS'] as $list ){?>
								<div class='dis_flex'>
									<input
										name="<?=$v['CODE']?>"
										type="radio"
										<?=( $list['ID'] == $v['VALUE'] ? 'checked' : '' )?>
										value="<?=$list['ID']?>">
									<div class='label'><?=$list['NAME']?></div>
								</div>
							<?}?>
						</div>
					<?}?>
				<?}else{?>				
					<?if( $v['MULTIPLE'] == 'Y' ){?>
						<select name="<?=$v['CODE']?>[]" multiple class='select'>							
							<?foreach( $v['ITEMS'] as $key => $list ){?>							
								<option									
									name='<?=$v['CODE']?>[ID_<?=$v['ID_PROP_VALUE'][$key]?>]'
									<?=( in_array( $list['ID'], $v['VALUE'] ) ? 'selected' : '' )?>
									value="<?=$list['ID']?>"><?=$list['NAME']?></option>
							<?}?>
						</select>
					<?}else{?>
						<select name="<?=$v['CODE']?>" class='select'>
							<?foreach( $v['ITEMS'] as $list ){?>
								<option
									name="<?=$v['CODE']?>"
									<?=(  $list['ID'] == $v['VALUE']  ? 'selected' : '' )?>
									value="<?=$list['ID']?>"><?=$list['NAME']?></option>
							<?}?>
						</select>
					<?}?>				
				<?}?>
			<?}elseif( $v['TYPE'] == 'P' ){?>
				<div>
					<input
						type='password'
						class='text'
						autocomplete='off'
						name='<?=$v['CODE']?>'
						value='<?=$VALUE?>'
						<?=$REQUIRED?> >
				</div>
			<?}elseif( $v['TYPE'] == 'F' ){?>
				<?if( $v['MULTIPLE'] == 'Y' ){?>				
					<?foreach( $v['VALUE'] as $v ){?>
						<div class='list_prop_enum'>
							<div class='dis_flex fild min-butt'>
								<a class='linkFil' target='_blank' href='<?=$v['LINK']?>'>Ссылка на файл</a>
								<div class="butt delFile" title='Удалить файл'>
									<a href="<?=$v['LINK_DEL']?>">&#10006;</a>
								</div>								
							</div>
						</div>					
					<?}?>
					<div class='list_prop_enum' data-multiple>
						<div class='dis_flex fild' data-multiple-clone>
							<div class="file-upload min-butt">
								<label>
									<input
										type='file'
										name='<?=$v['CODE']?>[]'
										<?=$REQUIRED?> >
									<span>Выберите Файл</span>
								</label>
							</div>
						</div>
						<div class='fild'>
							<div class="butt min-butt">
								<a href="#" data-multiple-sudmit>Ещё</a>
							</div>
						</div>
					</div>				
				<?}else{?>
					<?if( intval( $v['VALUE']['ID'] ) ){?>
						<div class='list_prop_enum'>
							<div class='dis_flex fild min-butt'>
								<a class='linkFil' target='_blank' href='<?=$v['VALUE']['LINK']?>'>Ссылка на файл</a>
								<div class="butt delFile" title='Удалить файл'>
									<a href="<?=$v['VALUE']['LINK_DEL']?>">&#10006;</a>
								</div>								
							</div>
						</div>						
					<?}else{?>
						<div class="file-upload min-butt">
							<label>
								<input
									type="file"
									name="<?=$v['CODE']?>"
									<?=$REQUIRED?> >
								<span>Выберите Файл</span>
							</label>
						</div>
					<?}?>
				<?}?>
			<?}else{?>
				<?if( $v['CODE'] == 'CODE' ){?>
					<div class='dis_flex' data-trans>
						<div class='code_inpun'>
							<input
								type='text'
								class='text'
								autocomplete='off'
								name='<?=$v['CODE']?>'
								value='<?=$VALUE?>'
								<?=$REQUIRED?> 
								data-trans-inp='NAME' >
						</div>
						<div class="butt trans">
							<a href="#" data-trans-send>Tr&uarr;</a>
						</div>
					</div>
				<?}else{?>
					<?if( $v['MULTIPLE'] == 'Y' ){?>
						<?foreach( $v['VALUE'] as $key => $item ){?>							
							<div class='list_prop_enum'>
								<div class='dis_flex fild'>
									<input
										type='text'
										class='text'
										autocomplete='off'
										name='<?=$v['CODE']?>[ID_<?=$v['ID_PROP_VALUE'][$key]?>]'
										value='<?=$item?>'
										<?=$REQUIRED?> >
								</div>
							</div>
						<?}?>					
						<div class='list_prop_enum' data-multiple>
							<div class='dis_flex fild' data-multiple-clone>
								<input
									type='text'
									class='text'
									autocomplete='off'
									name='<?=$v['CODE']?>[]'
									value='<?=$VALUE?>'
									<?=$REQUIRED?> >
							</div>
							<div class='fild'>
								<div class="butt min-butt">
									<a href="#" data-multiple-sudmit>Ещё</a>
								</div>
							</div>
						</div>					
					<?}else{?>
						<div>
							<input
								type='text'
								class='text'
								autocomplete='off'
								name='<?=$v['CODE']?>'
								value='<?=$VALUE?>'
								<?=$REQUIRED?> >
						</div>
					<?}?>
				<?}?>
			<?}?>
		</div>
	<?}?>	
<?}?>
<?if( !strlen( $arParam['ERR'] ) ){?>
	<div class='fild'>
		<form method='POST' class='form' enctype="multipart/form-data">
			<input type='hidden' name='FORM_NAME' value='<?=$arParam['FORM_NAME']?>'>
			<div class='block'>
				<div class='header'>Основные поля</div>
				<div class='content'>
					<?printField( $arParam['FIELD'] )?>
				</div>
			</div>
			<?if( count( $arParam['PROP'] ) ){?>
				<div class='block'>
					<div class='header'>Дополнительные свойства</div>
					<div class='content'>
						<?printField( $arParam['PROP'] )?>
					</div>
				</div>		
			<?}?>
			<div class='fild'>	
				<div class="butt min-butt">
					<a href="<?=$arParam['SAVE_ELM']['LINK']?>" data-send ><?=$arParam['SAVE_ELM']['NAME']?></a>
				</div>
			</div>
		</form>
	</div>
<?}else{?>
	<div><?=$arParam['ERR']?></div>
<?}?>
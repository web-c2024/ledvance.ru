<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="module-form-block-wr lk-page border_block">

<script>
	$(document).ready(function()
	{
		$("form.main-form").validate({rules:{ EMAIL: { email: true }}	});
		if(arAllcorp3Options['THEME']['PHONE_MASK'].length){
			var base_mask = arAllcorp3Options['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
			$('.lk-page input.phone').inputmask('mask', {'mask': arAllcorp3Options['THEME']['PHONE_MASK'], 'showMaskOnHover': false });
			$('.lk-page input.phone').blur(function(){
				if( $(this).val() == base_mask || $(this).val() == '' ){
					if( $(this).hasClass('required') ){
						$(this).parent().find('label.error').html(BX.message('JS_REQUIRED'));
					}
				}
			});
		}
	})
</script>
	<?global $arTheme;?>
	<div class="form">
		<div class="top-form bordered_block">
			<?ShowError($arResult["strProfileError"]);?>
			<?if( $arResult['DATA_SAVED'] == 'Y' ) {?><?ShowNote(GetMessage('PROFILE_DATA_SAVED'))?><br /><?; }?>
			<div class="big-title"><?=GetMessage('PROFILE_TITLE');?></div>
			<form method="post" name="form1" class="main-form" action="<?=$arResult["FORM_TARGET"]?>?" enctype="multipart/form-data">
				<?=$arResult["BX_SESSION_CHECK"]?>
				<input type="hidden" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				<?if($arTheme['CABINET']['DEPENDENT_PARAMS']['PERSONAL_ONEFIO']['VALUE'] != 'N'):?>
					<?
					$arName = array();
					$strName = '';
					if($arResult["arUser"]["LAST_NAME"]){
						$arName[] = $arResult["arUser"]["LAST_NAME"];
					}
					if($arResult["arUser"]["NAME"]){
						$arName[] = $arResult["arUser"]["NAME"];
					}
					if($arResult["arUser"]["SECOND_NAME"]){
						$arName[] = $arResult["arUser"]["SECOND_NAME"];
					}
					$strName = implode(' ', $arName);
					?>
					
					<div class="form-group <?=($strName ? 'input-filed' : '');?>">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label for="NAME" class="font_13 color_666"><?=GetMessage("PERSONAL_FIO")?>&nbsp;<span class="required-star">*</span></label>
								<div class="input">
									<input required type="text" class="form-control" name="NAME" id="NAME" maxlength="50" value="<?=$strName;?>" />
								</div>
							</div>
						</div>
					</div>
						
				<?else:?>
					
					<div class="form-group <?=($arResult["arUser"]["LAST_NAME"] ? 'input-filed' : '');?>">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label for="LAST_NAME" class="font_13 color_666"><?=GetMessage("PERSONAL_LASTNAME")?></label>
								<div class="input">
									<input type="text" class="form-control" name="LAST_NAME" id="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"];?>" />
								</div>
							</div>
						</div>
					</div>
						
					
					<div class="form-group <?=($arResult["arUser"]["NAME"] ? 'input-filed' : '');?>">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label for="NAME" class="font_13 color_666"><?=GetMessage("PERSONAL_NAME")?>&nbsp;<span class="required-star">*</span></label>
								<div class="input">
									<input required type="text" class="form-control" name="NAME" id="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"];?>" />
								</div>
							</div>
						</div>
					</div>
						
					
					<div class="form-group <?=($arResult["arUser"]["SECOND_NAME"] ? 'input-filed' : '');?>">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label for="SECOND_NAME" class="font_13 color_666"><?=GetMessage("PERSONAL_FATHERNAME")?></label>
								<div class="input">
									<input type="text" class="form-control" name="SECOND_NAME" id="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"];?>" />
								</div>
							</div>
						</div>
					</div>
						
				<?endif;?>
				
					<div class="form-group <?=($arResult["arUser"]["PERSONAL_PHONE"] ? 'input-filed' : '');?>">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label for="PERSONAL_PHONE" class="font_13 color_666"><?=GetMessage("PERSONAL_PHONE")?>&nbsp;<span class="required-star">*</span></label>
								<div class="input">
									<input required type="text" name="PERSONAL_PHONE" id="PERSONAL_PHONE" class="phone form-control" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" />
								</div>
							</div>
						</div>
					</div>
				
			
					<div class="form-group <?=($arResult["arUser"]["EMAIL"] ? 'input-filed' : '');?>">
						<div class="wrap_md">
							<div class="iblock label_block">
								<label for="EMAIL" class="font_13 color_666"><?=GetMessage("PERSONAL_EMAIL")?>&nbsp;<span class="required-star">*</span></label>
								<div class="input">
									<input required type="text" name="EMAIL" id="EMAIL" maxlength="50" class="form-control" value="<? echo $arResult["arUser"]["EMAIL"]?>" />
								</div>
							</div>
						</div>
						<?if($arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] == "Y"):?>
							<div class="text_block"><?=GetMessage('PERSONAL_EMAIL_DESCRIPTION');?></div>
						<?endif;?>
					</div>
				
				
			
					<?if($arTheme['CABINET']['DEPENDENT_PARAMS']["LOGIN_EQUAL_EMAIL"]["VALUE"] != "Y"):?>
						<div class="form-group <?=($arResult["arUser"]["LOGIN"] ? 'input-filed' : '');?>">
							<div class="wrap_md">
								<div class="iblock label_block">
									<label for="LOGIN" class="font_13 color_666"><?=GetMessage("PERSONAL_LOGIN")?>&nbsp;<span class="required-star">*</span></label>
									<div class="input">
										<input required type="text" name="LOGIN" id="LOGIN" maxlength="50" class="form-control" value="<? echo $arResult["arUser"]["LOGIN"]?>" />
									</div>
								</div>
							</div>
						</div>
					<?endif;?>
					<?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
						
								
						<div class="form-group">
							<div class="wrap_md">
								<div class="iblock label_block">
									<label for="NEW_PASSWORD" class="font_13 color_666"><?=GetMessage("NEW_PASSWORD")?></label>
									<div class="input">
										<input type="password" name="NEW_PASSWORD" id="NEW_PASSWORD" maxlength="50" class="form-control password" value="" />
									</div>
								</div>
							</div>
							<div class="text_block"><?=GetMessage('PERSONAL_PASWORD_TEXT');?></div>
						</div>					
						
								
							
						
						<div class="form-group">
							<div class="wrap_md">
								<div class="iblock label_block">
									<label for="NEW_PASSWORD_CONFIRM" class="font_13 color_666"><?=GetMessage("NEW_PASSWORD_CONFIRM")?></label>
									<div class="input">
										<input type="password" name="NEW_PASSWORD_CONFIRM" id="NEW_PASSWORD_CONFIRM" maxlength="50" class="form-control confirm_password" value="" />
									</div>
								</div>
							</div>
						</div>
							
					<?endif;?>
					<div class="but-r">
						<button class="btn btn-default bold btn-lg" type="submit" name="save" value="<?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE_TITLE") : GetMessage("MAIN_ADD_TITLE"))?>"><span><?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE_TITLE") : GetMessage("MAIN_ADD_TITLE"))?></span></button>
					</div>
				
			</form>
		</div>
		<?if($arResult["SOCSERV_ENABLED"]){ $APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "main", array("SUFFIX"=>"form", "SHOW_PROFILES" => "Y","ALLOW_DELETE" => "Y"),false,array("HIDE_ICONS"=>"Y"));}?>
	</div>
</div>
<?$APPLICATION->SetTitle(GetMessage('PERSONAL_DATA'));?>
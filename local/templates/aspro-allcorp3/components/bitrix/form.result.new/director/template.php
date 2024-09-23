<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?use \Bitrix\Main\Localization\Loc;?>
<div class="form inline<?=($arResult['FORM_NOTE'] ? ' success' : '')?><?=($arResult['isFormErrors'] == 'Y' ? ' error' : '')?>  border_block <?=$templateName;?>">
	<div class="top-form bordered_block">
		<?if(strlen($arResult["FORM_NOTE"])){?>
			<!--noindex-->
			<?if($arResult["isFormTitle"] == "Y"):?>
				<div class="form-header-text">
					<div class="text">
						<h3><?=($arResult['FORM_NOTE'] ? GetMessage("SUCCESS_TITLE") : $arResult["FORM_TITLE"]);?></h3>
						<div class="text_msg">
							<?$successNoteFile = SITE_DIR."include/form/success_{$arResult["arForm"]["SID"]}.php";?>
							<?if(\Bitrix\Main\IO\File::isFileExists(\Bitrix\Main\Application::getDocumentRoot().$successNoteFile)):?>
								<?$APPLICATION->IncludeFile($successNoteFile, array(), array("MODE" => "html", "NAME" => "Form success note"));?>
							<?elseif($arParams["SUCCESS_MESSAGE"]):?>
								<?=$arParams["SUCCESS_MESSAGE"];?>
							<?else:?>
								<?=GetMessage("FORM_SUCCESS");?>
							<?endif;?>
						</div>
					</div>
				</div>
			<?endif;?>
			
			<div class="form_result <?=($arResult["isFormErrors"] == "Y" ? 'error' : 'success')?>">
				<?if($arResult["isFormErrors"] == "Y"):?>
					<?=$arResult["FORM_ERRORS_TEXT"]?>
				<?else:?>
					<script>
						if(arAllcorp3Options['THEME']['USE_FORMS_GOALS'] !== 'NONE')
						{
							var id = '_'+'<?=((isset($arResult["arForm"]["ID"]) && $arResult["arForm"]["ID"]) ? $arResult["arForm"]["ID"] : $arResult["ID"] )?>';
							var eventdata = {goal: 'goal_webform_success' + (arAllcorp3Options['THEME']['USE_FORMS_GOALS'] === 'COMMON' ? '' : id)};
							BX.onCustomEvent('onCounterGoals', [eventdata]);
						}
					</script>
					<?if( $arParams["DISPLAY_CLOSE_BUTTON"] ){?>
						<div class="form-footer" style="text-align: left;">
							<button class="btn-lg <?=$arParams["CLOSE_BUTTON_CLASS"];?>"><?=($arParams["CLOSE_BUTTON_NAME"] ? $arParams["CLOSE_BUTTON_NAME"] : GetMessage("RELOAD_PAGE"));?></button>
						</div>
					<?}?>
				<?endif;?>
			</div>
		<?}?>
		<?if(!$arResult["FORM_NOTE"]){?>
			<?=$arResult["FORM_HEADER"]?>
				<?=bitrix_sessid_post();?>
				<?if($arResult["isFormDescription"] == "Y"):?>
					<div class="form-header-text">
						<div class="text">
							<div class=""><?=$arResult["FORM_DESCRIPTION"]?></div>
						</div>
					</div>
				<?endif;?>
				<?if($arResult["isFormErrors"] == "Y"):?>
					<div class="form-error alert alert-danger"><?=$arResult["FORM_ERRORS_TEXT"]?></div>
				<?endif;?>
				<div class="form-body questions-block">
					<div class="form-body__fields row flexbox">
					<?
					if (is_array($arResult["QUESTIONS"])) {
						foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion) {
							$field = TSolution\Form\Field\Factory::create('webform', [
								'FIELD_SID' => $FIELD_SID,
								'QUESTION' => $arQuestion,
								'PARAMS' => $arParams,
								'TYPE' => 'POPUP',
							]);

							$field->draw();

							if ($field->isTypeDate()) {
								$templateData['DATETIME'] = true;
							}
						}
					}
					?>
					</div>
					<?if($arResult["isUseCaptcha"] == "Y"):?>
						<div class="form-control captcha-row clearfix">
							<label class="font_13 color_999"><span><?=GetMessage("FORM_CAPRCHE_TITLE")?>&nbsp;<span class="star">*</span></span></label>
							<div class="captcha_image">
								<img src="/bitrix/tools/captcha.php?captcha_sid=<?=htmlspecialcharsbx($arResult["CAPTCHACode"])?>" border="0" />
								<input type="hidden" name="captcha_sid" value="<?=htmlspecialcharsbx($arResult["CAPTCHACode"])?>" />
								<div class="captcha_reload"></div>
							</div>
							<div class="captcha_input">
								<input type="text" class="inputtext captcha" name="captcha_word" size="30" maxlength="50" value="" required />
							</div>
						</div>
					<?elseif($arParams["HIDDEN_CAPTCHA"] == "Y"):?>
						<textarea name="nspm" style="display:none;"></textarea>
					<?endif;?>
				</div>
				<div class="form-footer" >
					<?if($arParams["SHOW_LICENCE"] == "Y"):?>
						<div class="licence_block form-checkbox">
							<input type="hidden" name="aspro_<?=VENDOR_SOLUTION_NAME?>_form_validate">
							<input type="checkbox" class="form-checkbox__input form-checkbox__input--visible" id="licenses_inline_<?=$arResult["arForm"]["ID"];?>" <?=(COption::GetOptionString(VENDOR_MODULE_ID, "LICENCE_CHECKED", "N") == "Y" ? "checked" : "");?> name="licenses_popup" required value="Y">
							<label for="licenses_inline_<?=$arResult["arForm"]["ID"];?>" class="form-checkbox__label">
								<span>
									<?include(str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].SITE_DIR."include/licenses_text.php"));?>
								</span>
								<span class="form-checkbox__box"></span>
							</label>
						</div>
					<?endif;?>
					<div class="text-left">
						<input type="submit" class="btn btn-default btn-lg" value="<?=$arResult["arForm"]["BUTTON"]?>" name="web_form_submit">
					</div>
				</div>
			<?=$arResult["FORM_FOOTER"]?>
		<?}?>
		<!--/noindex-->
		<script type="text/javascript">
		BX.message({
            FORM_FILE_DEFAULT: '<?= Loc::getMessage('FORM_FILE_DEFAULT') ?>',
		});
		$(document).ready(function(){
			$('form[name="<?=$arResult["arForm"]["VARNAME"]?>"]').validate({
				highlight: function( element ){
					$(element).parent().addClass('error');
				},
				unhighlight: function( element ){
					$(element).parent().removeClass('error');
				},
				submitHandler: function( form ){
					if( $('form[name="<?=$arResult["arForm"]["VARNAME"]?>"]').valid() ){
						setTimeout(function() {
							$(form).find('button[type="submit"]').attr("disabled", "disabled");
						}, 300);
						var eventdata = {type: 'form_submit', form: form, form_name: '<?=$arResult["arForm"]["VARNAME"]?>'};
						BX.onCustomEvent('onSubmitForm', [eventdata]);
					}
				},
				errorPlacement: function( error, element ){
					error.insertBefore(element);
				},
				messages:{
			      licenses_popup: {
			        required : BX.message('JS_REQUIRED_LICENSES')
			      }
				}
			});

			
			if(arAllcorp3Options['THEME']['PHONE_MASK'].length){
				var base_mask = arAllcorp3Options['THEME']['PHONE_MASK'].replace( /(\d)/g, '_' );
				$('form[name="<?=$arResult["arForm"]["VARNAME"]?>"] input.phone').inputmask('mask', {'mask': arAllcorp3Options['THEME']['PHONE_MASK'], 'showMaskOnHover': false });
				$('form[name="<?=$arResult["arForm"]["VARNAME"]?>"] input.phone').blur(function(){
					if( $(this).val() == base_mask || $(this).val() == '' ){
						if( $(this).hasClass('required') ){
							$(this).parent().find('div.error').html(BX.message('JS_REQUIRED'));
						}
					}
				});
			}
			
			if(arAllcorp3Options['THEME']['DATE_MASK'].length)
			{
				$('form[name="<?=$arResult["arForm"]["VARNAME"]?>"] input.date').inputmask('datetime', {
					'inputFormat':  arAllcorp3Options['THEME']['DATE_MASK'],
					'placeholder': arAllcorp3Options['THEME']['DATE_PLACEHOLDER'],
					'showMaskOnHover': false
				});
			}

			if(arAllcorp3Options['THEME']['DATETIME_MASK'].length)
			{
				$('form[name="<?=$arResult["arForm"]["VARNAME"]?>"] input.datetime').inputmask('datetime', {
					'inputFormat':  arAllcorp3Options['THEME']['DATETIME_MASK'],
					'placeholder': arAllcorp3Options['THEME']['DATETIME_PLACEHOLDER'],
					'showMaskOnHover': false
				});
			}

			$('.jqmClose').on('click', function(e){
				e.preventDefault();
				$(this).closest('.jqmWindow').jqmHide();
			})

			$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')});
			$(document).on('change', 'input[type=file]', function(){
				if($(this).val())
				{
					$(this).closest('.uploader').addClass('files_add');
				}
				else
				{
					$(this).closest('.uploader').removeClass('files_add');
				}
			})
			$('.form .add_file').on('click', function(){
				var index = $(this).closest('.input').find('input[type=file]').length+1;
				$('<input type="file" id="POPUP_FILE" name="FILE_n'+index+'"   class="inputfile" value="" />').insertBefore($(this));
				$('input[type=file]').uniform({fileButtonHtml: BX.message('JS_FILE_BUTTON_NAME'), fileDefaultHtml: BX.message('FORM_FILE_DEFAULT')});
			})
		});
		</script>
	</div>
</div>
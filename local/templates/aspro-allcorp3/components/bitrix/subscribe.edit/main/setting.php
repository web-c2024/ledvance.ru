<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//***********************************
//setting section
//***********************************
?>
<div class="top-form bordered_block">
<h4><?echo GetMessage("subscr_title_settings")?></h4>
<form action="<?=$arResult["FORM_ACTION"]?>" method="post" class="form subscribe-settings-form">
	<?echo bitrix_sessid_post();?>
	<?$email = ($arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"]);?>
	<div class="form-group <?=($email ? 'input-filed' : '');?>">	
		<label for="EMAIL" class="font_13 color_666"><?echo GetMessage("subscr_email")?>&nbsp;<span class="required-star">*</span></label>
		<div class="wrap-half-block">
			<div class="input">
				<input class="form-control" type="text" id="EMAIL" name="EMAIL" value="<?=$email;?>" size="30" maxlength="255" />
			</div>
			<div class="text_block"><?echo GetMessage("subscr_settings_note1")?> <?echo GetMessage("subscr_settings_note2")?></div>
		</div>
	</div>
	<div class="form-group option filter subscribes-block">
		<div class="subsection-title option-font-bold font_16"><?echo GetMessage("subscr_rub")?>&nbsp;<span class="required-star">*</span></div>
		<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<input class="form-checkbox__input" type="checkbox" name="RUB_ID[]" id="rub_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> />
			<label for="rub_<?=$itemValue["ID"]?>" class="form-checkbox__label">
				<span class="bx_filter_input_checkbox">
					<span><?=$itemValue["NAME"]?></span>
				</span>
				<span class="form-checkbox__box form-box"></span>
			</label>
		<?endforeach;?>
	</div>
	<div class="form-group option filter format-subscribe-group">
		<div class="subsection-title option-font-bold font_16"><?echo GetMessage("subscr_fmt")?></div>
		<div class="form-radiobox">
			<input class="form-radiobox__input" type="radio" id="text" name="FORMAT" value="text"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "text") echo " checked"?> />
			<label for="text" class="form-radiobox__label">
				<span class="bx_filter_input_checkbox">
					<span><?echo GetMessage("subscr_text")?></span>
				</span>
				<span class="form-radiobox__box"></span>
			</label>
		</div>
		&nbsp;&nbsp;
		<div class="form-radiobox">
			<input class="form-radiobox__input" type="radio" name="FORMAT" id="html" value="html"<?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo " checked"?> />
			<label for="html" class="form-radiobox__label">
				<span class="bx_filter_input_checkbox">
					<span>HTML</span>
				</span>
				<span class="form-radiobox__box"></span>
			</label>
		</div>
	</div>	

	<?global $arTheme;?>
	<?if($arTheme["SHOW_LICENCE"]["VALUE"] == "Y" && !$arResult["ID"] ):?>
		<div class="subscribe_licenses">
			<div class="licence_block filter label_block">
				<?if($arResult["ERROR"] && !$_POST["licenses_subscribe"]):?>
					<label id="licenses_subscribe-error" class="error" for="licenses_subscribe"><?=GetMessage("JS_REQUIRED_LICENSES");?></label>
				<?endif;?>
				<input class="form-checkbox__input form-checkbox__input--visible" type="checkbox" id="licenses_subscribe" <?=($_POST["licenses_subscribe"] ? "checked" : ($_POST ? "" : ($arTheme["SHOW_LICENCE"]["DEPENDENT_PARAMS"]["LICENCE_CHECKED"]["VALUE"] == "Y" ? "checked" : "")));?> name="licenses_subscribe" value="Y">
				<label for="licenses_subscribe" class="form-checkbox__label">
					<span>
						<?$APPLICATION->IncludeFile(SITE_DIR."include/licenses_text.php", Array(), Array("MODE" => "html", "NAME" => "LICENSES")); ?>
					</span>
					<span class="form-checkbox__box"></span>
				</label>
			</div>
		</div>
	<?endif;?>
	<div class=but-r>
		<input type="submit" class="btn btn-default btn-lg" name="Save" value="<?echo ($arResult["ID"] > 0? GetMessage("subscr_upd"):GetMessage("subscr_add"))?>" />
		<input type="reset" class="btn btn-default btn-transparent-bg white btn-lg" value="<?echo GetMessage("subscr_reset")?>" name="reset" />
	</div>

<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
<?if($_REQUEST["register"] == "YES"):?>
	<input type="hidden" name="register" value="YES" />
<?endif;?>
<?if($_REQUEST["authorize"]=="YES"):?>
	<input type="hidden" name="authorize" value="YES" />
<?endif;?>
</form>
</div>

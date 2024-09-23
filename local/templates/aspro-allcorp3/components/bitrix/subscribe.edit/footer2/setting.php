<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arParams["TITLE"]):?>
	<div class="white_middle_text"><?=$arParams["TITLE"];?></div>
<?endif;?>
<form action="<?=SITE_DIR.$arParams["PAGE"]?>" method="post" class="subscribe-form">
	<?echo bitrix_sessid_post();?>
	<input type="text" name="EMAIL" class="form-control subscribe-input required" placeholder="<?=GetMessage("EMAIL_INPUT");?>" value="<?=$arResult["USER_EMAIL"] ? $arResult["USER_EMAIL"] : ($arResult["SUBSCRIPTION"]["EMAIL"]!=""?$arResult["SUBSCRIPTION"]["EMAIL"]:$arResult["REQUEST"]["EMAIL"]);?>" size="30" maxlength="255" />

	<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
		<input type="hidden" name="RUB_ID[]" value="<?=$itemValue["ID"]?>" />
	<?endforeach;?>

	<input type="hidden" name="FORMAT" value="html" />
	<button type="submit" name="Save" class="btn btn-default btn-md subscribe-btn" title="<?echo GetMessage("ADD_USER");?>">
		<?=CAllcorp3::showIconSvg("save", SITE_TEMPLATE_PATH."/images/svg/Arrow.svg");?>
	</button>

	<input type="hidden" name="PostAction" value="Add" />
	<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
</form>

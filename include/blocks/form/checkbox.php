<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="filter <?=$arOptions["FIELD_TYPE"];?>">
	<input id="s<?=$arOptions["ID"];?>" 
		   class="form-<?=$arOptions['FIELD_TYPE_STRUCT'];?>__input form-<?=$arOptions['FIELD_TYPE_STRUCT'];?>__input--visible" 
		   name="form_<?=$arOptions['NAME'];?>"
		   type="<?=$arOptions["FIELD_TYPE"];?>" 
		   value="<?=$arOptions["ID"];?>"
	/>
	<label class="form-<?=$arOptions['FIELD_TYPE_STRUCT'];?>__label" 
		   for="s<?=$arOptions["ID"];?>"
	><?=$arOptions["MESSAGE"];?><span class="form-<?=$arOptions['FIELD_TYPE_STRUCT'];?>__box"></span></label>
</div>
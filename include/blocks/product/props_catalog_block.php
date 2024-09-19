<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="properties__item properties--mt-10 <?=$arConfig['JS_CLASS'];?>">
	<div class="properties__title font_sxs muted js-prop-title">
		<div class="hint hint--first"><?=$arConfig['PROP_TITLE'];?></div>
	</div>

	<div class="properties__value font_sm darken js-prop-value"><?=$arConfig['PROP_VALUE'];?></div>
</div>
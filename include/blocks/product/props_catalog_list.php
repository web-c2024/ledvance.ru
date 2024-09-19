<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="properties__item font_13 <?=$arConfig['JS_CLASS'];?>">
	<span class="properties__title color_999 js-prop-title"><?=$arConfig['PROP_TITLE'];?></span>
	<span class="properties__hr color_999 properties__item--inline">&mdash;</span>
	<span class="properties__value color_333 js-prop-value"><?=$arConfig['PROP_VALUE'];?></span>
</div>
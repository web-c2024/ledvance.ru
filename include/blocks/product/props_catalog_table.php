<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="line-block__item properties-table-item flexbox flexbox--justify-beetwen <?=$arConfig['JS_CLASS'];?>">
	<div class="properties__title font_12 color_999 js-prop-title"><?=$arConfig['PROP_TITLE'];?></div>
	<div class="properties__value color_333 font_14 font_short js-prop-value"><?=$arConfig['PROP_VALUE'];?></div>
</div>
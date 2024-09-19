<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="properties__item <?=$arConfig['JS_CLASS'];?>">
	<div class="properties__title properties__item--inline color_999 js-prop-title">
		<?=$arConfig['PROP_TITLE'];?>
		
		<?if ($arOptions["HINT"]):?>
			<div class="hint hint--down">
				<span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span>
				<div class="tooltip"><?=$arOptions["HINT"];?></div>
			</div>
		<?endif;?>
	</div>

	<div class="properties__hr properties__item--inline color_666">&mdash;</div>

	<div class="properties__value color_333 properties__item--inline js-prop-value"><?=$arConfig['PROP_VALUE'];?></div>
</div>
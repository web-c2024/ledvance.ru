<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arDefaultOptions = [
	'INNER_COUNTER_CLASS_LIST' => '',
];
$arOptions = array_merge($arDefaultOptions, $arConfig['PARAMS']);
?>
 <span class="bottom-icons-panel__content-link fill-theme-parent bottom-icons-panel__content-link--widget bottom-icons-panel__content-link--with-counter" 
 	data-event="jqm" 
	data-param-id="widget" 
	data-param-mobile="Y" 
	data-width="narrow" 
	data-name="widget"
>
	<?if ($arOptions['SHOW_IMAGE']):?>
		<span class="icon-block-with-counter__inner fill-theme-hover fill-theme-target<?=$arOptions['INNER_COUNTER_CLASS_LIST'];?>">
			<?if ($arOptions['ICON_SVG']):?>
				<?=$arOptions['ICON_SVG'];?>
			<?else:?>
				<img class="bottom-icons-panel__content-picture lazyload" 
					 src="<?=$arOptions['ICON'];?>" data-src="<?=$arOptions['ICON'];?>" 
					 alt="<?=$arOptions['NAME'];?>" title="<?=$arOptions['NAME'];?>" 
				/>
			<?endif;?>
		</span>
	<?endif;?>
	<?if ($arOptions['SHOW_TEXT']):?>
		<span class="bottom-icons-panel__content-text font_10 bottom-icons-panel__content-link--display--block"><?=$arOptions['NAME'];?></span>
	<?endif;?>
</span>
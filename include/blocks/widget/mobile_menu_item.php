<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="mobilemenu__menu mobilemenu__menu--widget">
	<ul class="mobilemenu__menu-list">
		<li class="mobilemenu__menu-item mobilemenu__menu-item--with-icon">
			<div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all color-theme-parent-all ">
				<span class="link-wrapper__span" data-event="jqm" data-param-id="widget" data-param-mobile="Y" data-width="narrow" data-name="widget">
					<span class="mobilemenu__menu-item-svg ">
						<?if ($arOptions['ICON_SVG']):?>
							<?=$arOptions['ICON_SVG'];?>
						<?else:?>
							<img class="widget-img" src="<?=$arOptions['WIDGET_ICON'];?>" alt="<?=$arOptions['WIDGET_TITLE'];?>" />
						<?endif;?>													
					</span>
					<span class="font_15"><?=$arOptions['WIDGET_TITLE'];?></span>
				</span>
			</div>
		</li>
	</ul>
</div>
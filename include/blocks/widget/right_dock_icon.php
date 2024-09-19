<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<span class="link fill-theme-hover" title="<?=$arOptions['TITLE'];?>">
	<span class="animate-load" 
		  data-event="jqm" 
		  data-param-id="widget" 
		  data-width="<?=$arOptions['WIDTH'];?>" 
		  data-name="widget" 
		  <?=$arOptions['SLIDE_DATA'];?>
	>
		<?if ($arOptions['ICON_SVG']):?>
			<?=$arOptions['ICON_SVG'];?>
		<?else:?>
			<img class="widget-img" src="<?=$arOptions['ICON'];?>" alt="<?=$arOptions['TITLE'];?>" />
		<?endif;?>
	</span>
</span>
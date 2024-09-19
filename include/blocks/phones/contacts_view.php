<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
$arPhones = $arOptions['PHONES'];
?>
<div class="contact-property contact-property--phones">
	<div class="contact-property__label font_13 color_999">
		<?=$arOptions['LABEL'];?>
	</div>
	
	<div class="<?=$arOptions['WRAPPER_CLASS_LIST'];?>" 
		 <?=$arOptions['FROM_REGION'] ? 'itemprop="telephone"' : '';?>
	>
		<?foreach ($arPhones as $arItem):?>
			<div class="contact-property__value<?=$arItem['WRAPPER_CLASS_LIST']?>" itemprop="telephone">
				<a href="<?=$arItem['HREF'];?>"<?=$arItem['DESCRIPTION'] ? ' title="'.$arItem['DESCRIPTION'].'"' : '';?>><?=$arItem['PHONE'];?></a>
			</div>
		<?endforeach;?>
	</div>
</div>
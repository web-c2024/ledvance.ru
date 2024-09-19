<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];

if (strlen($arOptions['ADDITIONAL_CLASS'])) {
	$arOptions['CLASS'] .= ' '.trim($arOptions['ADDITIONAL_CLASS']);
}
?>
<img src="<?=$arOptions['SRC'];?>" class="<?=$arOptions['CLASS'];?>" alt="<?=$arOptions['ALT'];?>" title="<?=$arOptions['ALT'];?>" />
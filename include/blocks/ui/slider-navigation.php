<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from \Aspro\Functions\CAsproPremier::showBlockHtml
$arOptions = $arConfig['PARAMS'];

/* icon wrapper class */
$wrapperClass = ['slider-nav'];
if ($arOptions['CLASSES']) {
  $wrapperClass[] = $arOptions['CLASSES'];
}
$wrapperClass = TSolution\Utils::implodeClasses($wrapperClass);

/* icon svg class */
$svgClass = $arOptions['SVG_CLASSES'] ?: 'stroke-dark-light';

/* icon size */
$iconSize = [
	'WIDTH' => 7, 
	'HEIGHT' => 12,
];
?>

<div class="slider-button-prev swiper-button-prev <?=$wrapperClass;?>">
	<?=TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/arrows.svg#left-hollow', $svgClass, $iconSize);?>
</div>
<div class="slider-button-next swiper-button-next <?=$wrapperClass;?>">
	<?=TSolution::showSpriteIconSvg(SITE_TEMPLATE_PATH.'/images/svg/arrows.svg#right-hollow', $svgClass, $iconSize);?>
</div>
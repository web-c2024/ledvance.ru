<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from \Aspro\Functions\CAsproPremier::showBlockHtml
$arOptions = $arConfig['PARAMS'];

$classList = ['swiper-pagination'];
if ($arOptions['CLASSES']) {
  $classList[] = $arOptions['CLASSES'];
}

$classList = TSolution\Utils::implodeClasses($classList);
?>
<div class="<?=$classList;?>"></div>
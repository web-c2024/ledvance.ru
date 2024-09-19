<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="video-block popup_video sm<?=$arOptions['ADDITIONAL_CLASS'];?>">
	<a class="video-block__play video-block__play--static video-block__play--sm bg-theme-after various video_link image dark-color" 
		href="<?=$arOptions['URL'];?>" title="<?=$arOptions['TITLE'];?>"
	>
		<span class="play text-upper font_xs"><?=$arOptions['TITLE'];?></span>
	</a>
</div>
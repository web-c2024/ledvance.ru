<?
if(\Bitrix\Main\Loader::includeModule('aspro.allcorp3'))
    $arThemeWidget = CAllcorp3::GetFrontParametrsValues(SITE_ID);
    $is_mobile = isset($_REQUEST["mobile"]) && $_REQUEST["mobile"] == "Y";
    $description = $arThemeWidget["WIDGET_DESCRIPTION"];
    $title = $arThemeWidget["WIDGET_TITLE"];
    $type = $arThemeWidget["WIDGET_TYPE"];
    $bWide = $arThemeWidget['WIDGET_WIDTH'] == 'wide' && !$is_mobile;
    $width = $bWide ? '465px' : '285px';

?>
<div class="popup_vidjet">
    <?if(strlen($title)):?>
        <div class="popup_vidjet__title switcher-title <?=($bWide ? 'font_24' : 'font_20')?> color_333">
            <?=$title?>
        </div>
    <?endif;?>
    <?if(strlen($description)):?>
        <div class="popup_vidjet__description font_13 color_999">
            <?=$description?>
        </div>
    <?endif;?>
    <div class="popup_vidjet__wrap ">
        <?if($type == 'type_1'):?>
            <?include(__DIR__.'/../include/widget_code.php');?>
        <?endif;?>
    </div> 
</div>

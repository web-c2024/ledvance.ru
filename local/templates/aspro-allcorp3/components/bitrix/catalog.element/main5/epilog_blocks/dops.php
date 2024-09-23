<?
use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'dops';
?>
<?//show dops block?>
<?if($arParams["SHOW_DOPS"] === 'Y'):?>
    <?if($bTab):?>
        <?if(!isset($bShow_dops)):?>
            <?$bShow_dops = true;?>
        <?else:?>
            <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="dops">
                <?$APPLICATION->ShowViewContent('PRODUCT_DOPS_INFO')?>
            </div>
        <?endif;?>
    <?else:?>
        <div class="detail-block ordered-block dops">
            <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_DOPS"]?></div>
            <?$APPLICATION->ShowViewContent('PRODUCT_DOPS_INFO')?>
        </div>
    <?endif;?>
<?endif;?>
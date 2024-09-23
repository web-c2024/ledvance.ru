<?
use \Bitrix\Main\Localization\Loc;

global $arTheme, $APPLICATION;

$bTab = isset($tabCode) && $tabCode === 'tariffs';
$bTariffsUseDetail = $arTheme['TARIFFS_USE_DETAIL']['VALUE'] === 'Y';
$tariffsDetailLinked = $arTheme['DETAIL_LINKED_TARIFFS']['VALUE'];

$blockTemplateOptions = $GLOBALS['arTheme']['DETAIL_LINKED_TARIFFS']['LIST'][$tariffsDetailLinked];
$bItemsOffset = $blockTemplateOptions['ADDITIONAL_OPTIONS']['LINKED_OFFSET_TARIFFS']['VALUE'] === 'Y';
$itemsImages = $tariffsDetailLinked=='type_1'?'BIG_PICTURES':$blockTemplateOptions['ADDITIONAL_OPTIONS']['LINKED_IMAGES_TARIFFS']['VALUE'];
?>
<?//show tariffs block?>
<?if($templateData['TARIFFS']['VALUE']):?>
    <?if(!isset($html_tariffs)):?>
        <?
        $GLOBALS['arrTariffsFilter'] = array('ID' => $templateData['TARIFFS']['VALUE']);
        $GLOBALS['arrTariffsFilter'] = array_merge($GLOBALS['arrTariffsFilter'], (array)$GLOBALS['arRegionLink']);
        ?>
        <?ob_start();?>
            <?TSolution\Functions::showBlockHtml([
                'FILE' => '/detail_linked_tarifs.php',
                'PARAMS' => array_merge($arParams, [
                    "IBLOCK_ID" => $templateData['TARIFFS']['IBLOCK_ID']
                ])
            ]);?>
        <?$html_tariffs = trim(ob_get_clean());?>
    <?endif;?>

    <?if($html_tariffs && strpos($html_tariffs, 'error') === false):?>
        <?if($bTab):?>
            <?if(!isset($bShow_tariffs)):?>
                <?$bShow_tariffs = true;?>
            <?else:?>
                <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="tariffs">
                    <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_TARIFFS"]?></div>
                    <?=$html_tariffs?>
                </div>
            <?endif;?>
        <?else:?>
            <div class="detail-block ordered-block tariffs">
                <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_TARIFFS"]?></div>
                <?=$html_tariffs?>
            </div>
        <?endif;?>
    <?endif;?>
<?endif;?>
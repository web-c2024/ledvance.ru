<?
use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'news';
?>
<?//show news block?>
<?if($templateData['NEWS']['VALUE'] && $templateData['NEWS']['IBLOCK_ID']):?>
    <?if(!isset($html_news)):?>
        <?
        $GLOBALS['arrNewsFilter'] = array('ID' => $templateData['NEWS']['VALUE']);
        $GLOBALS['arrNewsFilter'] = array_merge($GLOBALS['arrNewsFilter'], (array)$GLOBALS['arRegionLink']);

        $bCheckAjaxBlock = CAllcorp3::checkRequestBlock("news-list-inner");
        ?>
        <?ob_start();?>
            <?$APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "items-list-inner",
                array(
                    "IBLOCK_TYPE" => "aspro_allcorp3_content",
                    "IBLOCK_ID" => $templateData['NEWS']['IBLOCK_ID'],
                    "NEWS_COUNT" => "20",
                    "SORT_BY1" => "ACTIVE_FROM",
                    "SORT_ORDER1" => "DESC",
                    "SORT_BY2" => "SORT",
                    "SORT_ORDER2" => "ASC",
                    "FILTER_NAME" => "arrNewsFilter",
                    "FIELD_CODE" => array(
                        0 => "NAME",
                        1 => "PREVIEW_TEXT",
                        2 => "PREVIEW_PICTURE",
                        3 => "DATE_ACTIVE_FROM",
                        4 => "",
                    ),
                    "PROPERTY_CODE" => array(
                        0 => "PERIOD",
                        1 => "REDIRECT",
                        2 => "",
                    ),
                    "CHECK_DATES" => "Y",
                    "DETAIL_URL" => "",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "N",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "ACTIVE_DATE_FORMAT" => "j F Y",
                    "SET_TITLE" => "N",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "PAGER_TEMPLATE" => ".default",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "PAGER_TITLE" => "",
                    "PAGER_SHOW_ALWAYS" => "N",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "COUNT_IN_LINE" => "3",
                    "SHOW_DATE" => "Y",

                    "ROW_VIEW" => true,
                    "BORDER" => true,
                    "ITEM_HOVER_SHADOW" => true,
                    "DARK_HOVER" => false,
                    "ROUNDED" => true,
                    "ROUNDED_IMAGE" => true,
                    "ITEM_PADDING" => true,
                    "ELEMENTS_ROW" => 1,
                    "MAXWIDTH_WRAP" => false,
                    "MOBILE_SCROLLED" => false,
                    "NARROW" => false,
                    "ITEMS_OFFSET" => false,
                    "IMAGES" => "PICTURE",
                    "IMAGE_POSITION" => "LEFT",
                    "SHOW_PREVIEW" => true,
                    "SHOW_TITLE" => false,
                    "SHOW_SECTION" => "N",
                    "TITLE_POSITION" => "",
                    "TITLE" => "",
                    "RIGHT_TITLE" => "",
                    "RIGHT_LINK" => "",
                    "CHECK_REQUEST_BLOCK" => $bCheckAjaxBlock,
                    "IS_AJAX" => CAllcorp3::checkAjaxRequest() && $bCheckAjaxBlock,
                    "NAME_SIZE" => "18",
                    "SUBTITLE" => "",
                    "SHOW_PREVIEW_TEXT" => "N",
                ),
                false, array("HIDE_ICONS" => "Y")
            );?>
        <?$html_news = trim(ob_get_clean());?>
    <?endif;?>

    <?if($html_news && strpos($html_news, 'error') === false):?>
        <?if($bTab):?>
            <?if(!isset($bShow_news)):?>
                <?$bShow_news = true;?>
            <?else:?>
                <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="news">
                    <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_NEWS"]?></div>
                    <?=$html_news?>
                </div>
            <?endif;?>
        <?else:?>
            <div class="detail-block ordered-block news">
                <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_NEWS"]?></div>
                <?=$html_news?>
            </div>
        <?endif;?>
    <?endif;?>
<?endif;?>
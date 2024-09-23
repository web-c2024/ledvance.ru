<?
use \Bitrix\Main\Localization\Loc;

$bTab = isset($tabCode) && $tabCode === 'faq';
?>
<?//show faq block?>
<?if($templateData['FAQ']['VALUE'] && $templateData['FAQ']['IBLOCK_ID']):?>
    <?if(!isset($html_faq)):?>
        <?
        $GLOBALS['arrFaqFilter'] = array('ID' => $templateData['FAQ']['VALUE']);
        $GLOBALS['arrFaqFilter'] = array_merge($GLOBALS['arrFaqFilter'], (array)$GLOBALS['arRegionLink']);

        $bCheckAjaxBlock = CAllcorp3::checkRequestBlock("faq-list-inner");
        ?>
        <?ob_start();?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "faq-list",
            array(
                "IBLOCK_TYPE" => "aspro_allcorp3_content",
                "IBLOCK_ID" => $templateData['FAQ']['IBLOCK_ID'],
                "NEWS_COUNT" => "20",
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "ID",
                "SORT_ORDER2" => "DESC",
                "FILTER_NAME" => "arrFaqFilter",
                "FIELD_CODE" => array(
                    0 => "",
                    1 => "",
                ),
                "PROPERTY_CODE" => array(
                    0 => "TITLE_BUTTON",
                    1 => "LINK_BUTTON",
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
                "ACTIVE_DATE_FORMAT" => "d.m.Y",
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
                "COMPONENT_TEMPLATE" => "faq-list",
                "SET_LAST_MODIFIED" => "N",
                "STRICT_SECTION_CHECK" => "N",
                "SHOW_DETAIL_LINK" => "Y",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "SHOW_404" => "N",
                "MESSAGE_404" => "",
                "SHOW_DATE" => "Y",
                "COUNT_IN_LINE" => "4",

                "ROW_VIEW" => true,
                "BORDER" => true,
                "ITEM_HOVER_SHADOW" => true,
                "DARK_HOVER" => false,
                "ROUNDED" => true,
                "ITEM_PADDING" => true,
                "ELEMENTS_ROW" => 1,
                "MAXWIDTH_WRAP" => false,
                "MOBILE_SCROLLED" => false,
                "NARROW" => false,
                "ITEMS_OFFSET" => false,
                "SHOW_PREVIEW" => false,
                "SHOW_TITLE" => false,
                "SHOW_SECTION" => "Y",
                "TITLE_POSITION" => "",
                "TITLE" => "",
                "RIGHT_TITLE" => "",
                "RIGHT_LINK" => "",
                "CHECK_REQUEST_BLOCK" => $bCheckAjaxBlock,
                "IS_AJAX" => CAllcorp3::checkAjaxRequest() && $bCheckAjaxBlock,
                "NAME_SIZE" => "16",
                "SUBTITLE" => "",
                "SHOW_PREVIEW_TEXT" => "Y",
            ),
            false, array("HIDE_ICONS" => "Y")
        );?>
        <?$html_faq = trim(ob_get_clean());?>
    <?endif;?>

    <?if($html_faq && strpos($html_faq, 'error') === false):?>
        <?if($bTab):?>
            <?if(!isset($bShow_faq)):?>
                <?$bShow_faq = true;?>
            <?else:?>
                <div class="tab-pane <?=(!($iTab++) ? 'active' : '')?>" id="faq">
                    <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_FAQ"]?></div>
                    <?=$html_faq?>
                </div>
            <?endif;?>
        <?else:?>
            <div class="detail-block ordered-block faq">
                <div class="ordered-block__title switcher-title font_22"><?=$arParams["T_FAQ"]?></div>
                <?=$html_faq?>
            </div>
        <?endif;?>
    <?endif;?>
<?endif;?>
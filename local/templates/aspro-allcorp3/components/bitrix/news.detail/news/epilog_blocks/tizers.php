<?
use \Bitrix\Main\Localization\Loc;

$cntTizers = 3;
?>
<?//show tizers block?>
<?if($templateData['TIZERS']['VALUE'] && $templateData['TIZERS']['IBLOCK_ID'] && $cntTizers):?>
    <?
    $GLOBALS['arrTizersFilter'] = array('ID' => $templateData['TIZERS']['VALUE']);
    $GLOBALS['arrTizersFilter'] = array_merge($GLOBALS['arrTizersFilter'], (array)$GLOBALS['arRegionLink']);
    ?>
    <?ob_start();?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list", 
            "tizers-list", 
            array(
                "IBLOCK_TYPE" => "aspro_allcorp3_content",
                "IBLOCK_ID" => $templateData['TIZERS']['IBLOCK_ID'],
                "NEWS_COUNT" => $cntTizers,
                "SORT_BY1" => "SORT",
                "SORT_ORDER1" => "ASC",
                "SORT_BY2" => "ID",
                "SORT_ORDER2" => "ASC",
                "FILTER_NAME" => "arrTizersFilter",
                "FIELD_CODE" => array(
                    0 => "NAME",
                    1 => "PREVIEW_TEXT",
                    2 => "PREVIEW_PICTURE",
                    3 => "DETAIL_PICTURE",
                    4 => "DETAIL_TEXT",
                ),
                "PROPERTY_CODE" => array(
                    0 => "",
                    1 => "LINK",
                    2 => "TYPE",
                    3 => "TIZER_ICON",
                ),
                "CHECK_DATES" => "Y",
                "DETAIL_URL" => "",
                "AJAX_MODE" => "N",
                "AJAX_OPTION_JUMP" => "N",
                "AJAX_OPTION_STYLE" => "Y",
                "AJAX_OPTION_HISTORY" => "N",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600000",
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
                "INCLUDE_SUBSECTIONS" => "N",
                "PAGER_TEMPLATE" => "ajax",
                "DISPLAY_TOP_PAGER" => "N",
                "DISPLAY_BOTTOM_PAGER" => "N",
                "PAGER_TITLE" => "",
                "PAGER_SHOW_ALWAYS" => "N",
                "PAGER_DESC_NUMBERING" => "N",
                "PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
                "PAGER_SHOW_ALL" => "N",
                "SET_BROWSER_TITLE" => "N",
                "SET_META_KEYWORDS" => "N",
                "SET_META_DESCRIPTION" => "N",
                "COMPONENT_TEMPLATE" => "tizers-list",
                "SET_LAST_MODIFIED" => "N",
                "STRICT_SECTION_CHECK" => "N",
                "PAGER_BASE_LINK_ENABLE" => "N",
                "SHOW_404" => "N",
                "MESSAGE_404" => "",

                "MOBILE_SCROLLED" => false,
                'TEXT_CENTERED' => false,
                'FRONT_PAGE' => false,
                'NARROW' => true,
                'TOP_TEXT_SIZE' => '50',
                'ITEMS_OFFSET' => true,
                'IMAGES' => 'ICONS',
                'IMAGE_POSITION' => 'LEFT',
                'WRAPPER_OFFSET' => true,
                'ITEMS_COUNT' => 4,
            ),
            false, array("HIDE_ICONS" => "Y")
        );?>
    <?$html = trim(ob_get_clean());?>
    <?if($html && strpos($html, 'error') === false):?>
        <?if (reset($arBlockOrder) !== 'tizers' || !$templateData['IMG_TOP_SIDE']):?>
            <div class="detail-block bordered ordered-block rounded-4 tizers"><?=$html?></div>
        <?else:?>
            <?$APPLICATION->AddViewContent('top_detail_content', '<div class="maxwidth-theme tizers-top-side"><div class="detail-block bordered rounded-4 tizers">'.$html.'</div></div>');?>
        <?endif;?>
    <?endif;?>
<?endif;?>
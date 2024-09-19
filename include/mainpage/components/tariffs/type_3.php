<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$indexPageOptions = $GLOBALS['arTheme']['INDEX_TYPE']['SUB_PARAMS'][$GLOBALS['arTheme']['INDEX_TYPE']['VALUE']];
$blockOptions = $indexPageOptions['TARIFFS'];
$blockTemplateOptions = $blockOptions['TEMPLATE']['LIST'][$blockOptions['TEMPLATE']['VALUE']];
$bTariffsUseDetail = $GLOBALS['arTheme']['TARIFFS_USE_DETAIL']['VALUE'] === 'Y';
$defaultPriceKey = $GLOBALS['arTheme']['TARIFFS_DEFAULT_PRICE_KEY']['VALUE'] ?? 'DEFAULT';
$defaultItemName = $GLOBALS['arTheme']['TARIFFS_DEFAULT_ITEM_NAME']['VALUE'] ?? '';
$defaultFallback = $GLOBALS['arTheme']['TARIFFS_DEFAULT_FALLBACK']['VALUE'] ?? '';

$tabs = $blockOptions["INDEX_BLOCK_OPTIONS"]["BOTTOM"]["TABS"]["VALUE"];
if ($tabs === 'TOP') {
	$iblockId = TSolution\Cache::$arIBlocks[SITE_ID]['aspro_allcorp3_catalog']['aspro_allcorp3_tarifs'][0];
	$defaultPriceKey = $defaultItemName = TSolution\Property\TariffItem::mkTabFilter($iblockId, 'arFrontFilter');
}
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"tariffs-list",
	array(
		"IBLOCK_TYPE" => "aspro_allcorp3_catalog",
		"IBLOCK_ID" => "35",
		"NEWS_COUNT" => "4",
		"SORT_BY1" => "SORT",
		"SORT_ORDER1" => "ASC",
		"SORT_BY2" => "ID",
		"SORT_ORDER2" => "DESC",
		"FILTER_NAME" => "arFrontFilter",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "FORM_ORDER",
			1 => "HIT",
			2 => "ONLY_ONE_PRICE",
			3 => "PRICE_CURRENCY",
			4 => "TARIF_PRICE_1",
			5 => "TARIF_PRICE_2",
			6 => "TARIF_PRICE_2_DISC",
			7 => "TARIF_PRICE_3",
			8 => "TARIF_PRICE_3_DISC",
			9 => "TARIF_PRICE_DEFAULT",
			10 => "TARIF_PRICE_DEFAULT_DISC",
			11 => "MULTI_PROP_BOTTOM_PROPS",
			12 => "MULTI_PROP",
			13 => "SUPPLIED",
			14 => "USERS",
			15 => "EXTENSION",
			16 => "DURATION",
			17 => "GROUPS_USERS",
			18 => "TASK",
			19 => "ADMIN",
			20 => "VOLUME",
			21 => "ONLINE",
			22 => "FILE_STORAGE",
			23 => "MESSAGE",
			24 => "MEMORY",
			25 => "CPU",
			26 => "IP",
			27 => "HOSTING_SITES",
			28 => "KOLLICHESTVO_BAZ_DANNIX",
			29 => "UPDATES",
			30 => "LANGUAGES",
			31 => "TARIF_PRICE_1_DISC",
			32 => "TARIF_PRICE_4",
			33 => "ICON",
			34 => "VISA",
			35 => "NUM_DEVICES",
			36 => "APPLE",
			37 => "ELPURSE",
			38 => "API_INTEGRATION",
			39 => "SIEM_SYSTEM",
			40 => "COLLECT_INFO",
			41 => "RULES_SIGNAT",
			42 => "SCANNER",
			43 => "ANTIVIRUS",
			44 => "PROTECT_PAYMENT",
			45 => "PROTECT_CAMERA",
			46 => "ANTIVOR",
			47 => "CONTROL",
			48 => "SUPPORT_FREE",
			49 => "GUARANTEE",
			50 => "BLOCKING_SITES",
			51 => "BLOCKING_TRAFFIC",
			52 => "SECURITY",
			53 => "PROTECT_CHILDREN",
			54 => "SUM_FINANCING",
			55 => "TERM_LEASING",
			56 => "INSURANCE",
			57 => "CURRENCY",
			58 => "ADVANCE_PAY",
			59 => "RATE",
			60 => "PERCENTAGE",
			61 => "PAYMENTS",
			62 => "SUPPORT",
			63 => "NOTIFICATION",
			64 => "TURN",
			65 => "TARIF_ITEM",
			66 => "",
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
		"INCLUDE_SUBSECTIONS" => "Y",
		"PAGER_TEMPLATE" => "ajax",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600000",
		"PAGER_SHOW_ALL" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"COMPONENT_TEMPLATE" => "tariffs-list",
		"SET_LAST_MODIFIED" => "N",
		"STRICT_SECTION_CHECK" => "Y",
		"SHOW_DETAIL_LINK"	=>	"Y",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => "",
		"SHOW_DATE" => "N",
		"COUNT_IN_LINE" => "1",

		"USE_DETAIL"	=>	$bTariffsUseDetail?"Y":"N",
		"VISIBLE_PROP_COUNT" => "4",
		"ROW_VIEW" => true,
		"BORDER" => true,
		"ITEM_HOVER_SHADOW" => true,
		"DARK_HOVER" => false,
		"ROUNDED" => true,
		"ROUNDED_IMAGE" => false,
		"ELEMENTS_ROW" => "1",
		"MAXWIDTH_WRAP" => true,
		"MOBILE_SCROLLED" => true,
		"HIDE_PAGINATION" => "N",
		"SLIDER" => false,
		"VIEW_TYPE" => "type_3",
		"ORDER_VIEW" => CAllcorp3::GetFrontParametrValue('ORDER_VIEW') == 'Y',
		"NARROW" => $blockTemplateOptions["ADDITIONAL_OPTIONS"]["WIDE"]["VALUE"]!="Y",
		"ITEMS_OFFSET" => $blockTemplateOptions["ADDITIONAL_OPTIONS"]["ITEMS_OFFSET"]["VALUE"]=="Y",
		"IMAGES" => $blockTemplateOptions["ADDITIONAL_OPTIONS"]["IMAGES"]["VALUE"],
		"HIDE_LEFT_TEXT_BLOCK" => "Y",
		"TABS" => $tabs,
		"DEFAULT_PRICE_KEY" => $defaultPriceKey,
		"DEFAULT_ITEM_NAME" => $defaultItemName,
		"DEFAULT_FALLBACK" => $defaultFallback,
		"SHOW_TITLE" => $blockOptions["INDEX_BLOCK_OPTIONS"]["BOTTOM"]["SHOW_TITLE"]["VALUE"]=="Y",
		"TITLE_POSITION" => $blockOptions["INDEX_BLOCK_OPTIONS"]["BOTTOM"]["TITLE_POSITION"]["VALUE"],
		"TITLE" => "Тарифы",
		"RIGHT_TITLE" => $GLOBALS['arTheme']['TARIFFS_USE_DETAIL']['VALUE'] === 'Y'?"Все тарифы":"",
		"RIGHT_LINK" => $GLOBALS['arTheme']['TARIFFS_USE_DETAIL']['VALUE'] === 'Y'?"tariffs/":"",
		"CHECK_REQUEST_BLOCK" => CAllcorp3::checkRequestBlock("tariffs"),
		"IS_AJAX" => CAllcorp3::checkAjaxRequest(),
		"NAME_SIZE" => 22,
		"SUBTITLE" => "",
		"SHOW_PREVIEW_TEXT" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
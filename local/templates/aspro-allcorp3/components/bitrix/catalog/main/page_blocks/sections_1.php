<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

$bShowChilds = $arParams['SHOW_CHILD_SECTIONS'] !== 'N';
$bShowPreviewText = $arParams['SECTIONS_LIST_PREVIEW_DESCRIPTION'] !== 'N';
if($arParams['SECTIONS_TYPE_VIEW'] === 'FROM_MODULE'){
	$blockTemplateOptions = $GLOBALS['arTheme']['SECTIONS_TYPE_VIEW_CATALOG']['LIST'][$GLOBALS['arTheme']['SECTIONS_TYPE_VIEW_CATALOG']['VALUE']];
	$bItemsOffset = $blockTemplateOptions['ADDITIONAL_OPTIONS']['SECTIONS_ITEMS_OFFSET_CATALOG']['VALUE'] === 'Y';
	$elementsCount = $blockTemplateOptions['ADDITIONAL_OPTIONS']['SECTIONS_ELEMENTS_COUNT_CATALOG']['VALUE'];
	$textPosition = $blockTemplateOptions['ADDITIONAL_OPTIONS']['SECTIONS_TEXT_POSITION_CATALOG']['VALUE'];
}
else{
	$bItemsOffset = $arParams['SECTIONS_ITEMS_OFFSET'] === 'Y';
	$elementsCount = $arParams['SECTIONS_ELEMENTS_COUNT'];
	$textPosition = $arParams['SECTIONS_TEXT_POSITION'];
}
?>
<?$APPLICATION->IncludeComponent(
	"aspro:catalog.section.list.allcorp3", 
	".default", 
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"	=> $arParams["IBLOCK_ID"],
		"CACHE_TYPE"	=>	$arParams["CACHE_TYPE"],
		"CACHE_TIME"	=>	$arParams["CACHE_TIME"],
		"CACHE_FILTER"	=>	$arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"FILTER_NAME"	=>	$arParams["FILTER_NAME"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"ADD_SECTIONS_CHAIN" => "N",
		"COMPONENT_TEMPLATE" => ".default",
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_FIELDS" => array(
			0 => "NAME",
			1 => "DESCRIPTION",
			2 => "PICTURE",
			3 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "UF_TOP_SEO",
			1 => "UF_SECTION_ICON",
			2 => "UF_MIN_PRICE",
			3 => "UF_TRANSPARENT_PICTURE",
			4 => "",
		),
		"ROW_VIEW" => false,
		"BORDER" => false,
		"ITEM_HOVER_SHADOW" => false,
		"DARK_HOVER" => $textPosition=="BG",
		"ROUNDED" => true,
		"ROUNDED_IMAGE" => false,
		"ITEM_PADDING" => false,
		"SECTION_COUNT" => "999",
		"ELEMENTS_ROW" => $elementsCount,
		"MAXWIDTH_WRAP" => false,
		"MOBILE_SCROLLED" => $bMobileSectionsCompact,
		"NARROW" => true,
		"ITEMS_OFFSET" => $bItemsOffset,
		"IMAGES" => "PICTURES",
		"IMAGE_POSITION" => $textPosition=="BG" ? "BG" : "TOP",
		"SHOW_PREVIEW" => $bShowPreviewText,
		"SHOW_CHILDS" => $bShowChilds,
		"CHECK_REQUEST_BLOCK" => CAllcorp3::checkRequestBlock("catalog_sections"),
		"IS_AJAX" => CAllcorp3::checkAjaxRequest(),
		"NAME_SIZE" => "18",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
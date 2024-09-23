<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

global $arTheme, $APPLICATION;

$bShowLeftBlock = ($arTheme['LEFT_BLOCK_SERVICES_ROOT']['VALUE'] === 'Y' && !defined('ERROR_404'));
$APPLICATION->SetPageProperty('MENU', ($bShowLeftBlock ? 'Y' : 'N' ));
?>
<?// intro text?>
<?ob_start();?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	"",
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => ""
	)
);?>
<?$html = ob_get_contents();?>
<?ob_end_clean();?>
<?if($html && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
	<div class="text_before_items">
		<?=$html;?>
	</div>
<?endif;?>
<?
// get section items count and subsections
$arItemFilter = TSolution::GetCurrentSectionElementFilter($arResult["VARIABLES"], $arParams, false);
$arSubSectionFilter = TSolution::GetCurrentSectionSubSectionFilter($arResult["VARIABLES"], $arParams, false);
$itemsCnt = TSolution\Cache::CIBlockElement_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());
$arSubSections = TSolution\Cache::CIBlockSection_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]), "MULTI" => "Y")), $arSubSectionFilter, false, array("ID"));

// is ajax: need for ajax pagination
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'  && isset($_GET['ajax_get']) && $_GET['ajax_get'] === 'Y' || (isset($_GET['AJAX_REQUEST']) && $_GET['AJAX_REQUEST'] === 'Y');

?>
<?if(!$itemsCnt && !$arSubSections):?>
	<div class="alert alert-warning"><?=GetMessage("SECTION_EMPTY")?></div>
<?else:?>
	<?TSolution::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);?>

	<?// rss?>
	<?if($arParams['USE_RSS'] !== 'N'):?>
		<?$this->SetViewTarget('cowl_buttons');?>
		<?TSolution\Functions::ShowRSSIcon(
			array(
				'URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['rss']
			)
		);?>
		<?$this->EndViewTarget();?>
	<?endif;?>

	<?$sViewElementTemplate = ($arParams["SECTIONS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["SECTIONS_TYPE_VIEW_SERVICES"]["VALUE"] : $arParams["SECTIONS_TYPE_VIEW"]);?>
	<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>

	<?if(!$arSubSections):?>
		<?// section elements?>
		<?if(strlen($arParams["FILTER_NAME"])):?>
			<?$GLOBALS[$arParams["FILTER_NAME"]] = array_merge((array)$GLOBALS[$arParams["FILTER_NAME"]], $arItemFilter);?>
		<?else:?>
			<?$arParams["FILTER_NAME"] = "arrFilter";?>
			<?$GLOBALS[$arParams["FILTER_NAME"]] = $arItemFilter;?>
		<?endif;?>

		<?$sViewElementTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["ELEMENTS_PAGE_SERVICES"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);?>
		<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
	<?endif;?>
<?endif;?>
<?// outro text?>
<?ob_start();?>
<div class="text_after_items">
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "bottom",
			"EDIT_TEMPLATE" => ""
		)
	);?>
</div>
<?$html = ob_get_contents();?>
<?ob_end_clean();?>
<?if(trim($html) && strpos($_SERVER['REQUEST_URI'], 'PAGEN') === false):?>
	<?=$html;?>
<?endif;?>
<?unset($html);?>

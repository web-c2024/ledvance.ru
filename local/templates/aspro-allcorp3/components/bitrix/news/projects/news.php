<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>

<?
global $arTheme, $APPLICATION;
$bShowLeftBlock = ($arTheme['PROJECT_PAGE_LEFT_BLOCK']['VALUE'] === 'Y' && !defined('ERROR_404'));
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
	), ['HIDE_ICONS' => 'Y']
);?>
<?$html = ob_get_contents();
ob_end_clean();?>
<?if($html):?>
	<div class="text_before_items">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "page",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => ""
			), ['HIDE_ICONS' => 'Y']
		);?>
	</div>
<?endif;?>
<?
$arItemFilter = TSolution::GetIBlockAllElementsFilter($arParams);

if ($arParams['CACHE_GROUPS'] == 'Y') {
	$arItemFilter['CHECK_PERMISSIONS'] = 'Y';
	$arItemFilter['GROUPS'] = $GLOBALS["USER"]->GetGroups();
}

$itemsCnt = TSolution\Cache::CIblockElement_GetList(array("CACHE" => array("TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), $arItemFilter, array());?>

<?if (!$itemsCnt):?>
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
	
	<?// show top map?>
	<?include('include/top-map.php')?>
	
	<?$bUseMixLink = (
		$arTheme['PROJECTS_SHOW_HEAD_BLOCK']['VALUE'] == 'Y' &&
		in_array($arTheme["PROJECTS_SHOW_HEAD_BLOCK"]["DEPENDENT_PARAMS"]['SHOW_HEAD_BLOCK_TYPE']['VALUE'], ['sections_mix', 'years_mix'])
	);?>
	<?if ($bUseMixLink):?>
		<div class="mixitup-container">
	<?endif;?>

	<?// get SECTIONS and TAG for right block?>
	<?$arSideInfo = TSolution\Functions::getSectionsWithElementCount([
		'FILTER' => $arItemFilter,
		'PARAMS' => $arParams
	])?>

	<? // tags cloud ?>
	<? ob_start(); ?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:search.tags.cloud",
			"main",
			Array( 
				"CACHE_TIME" => "86400",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "Y",
				"COLOR_NEW" => "3E74E6",
				"COLOR_OLD" => "C0C0C0",
				"COLOR_TYPE" => "N",
				"FILTER_NAME" => "",
				"FONT_MAX" => "50",
				"FONT_MIN" => "10",
				"PAGE_ELEMENTS" => "150",
				"TAGS_ELEMENT" => $arSideInfo['TAGS'],
				"FILTER_NAME" => $arParams["FILTER_NAME"],
				"PERIOD" => "",
				"PERIOD_NEW_TAGS" => "",
				"SHOW_CHAIN" => "N",
				"SORT" => "NAME",
				"TAGS_INHERIT" => "Y",
				"URL_SEARCH" => SITE_DIR."search/index.php",
				"WIDTH" => "100%",
				"arrFILTER" => array("iblock_aspro_".VENDOR_SOLUTION_NAME."_content"),
				"arrFILTER_iblock_aspro_".VENDOR_SOLUTION_NAME."_content" => array($arParams["IBLOCK_ID"])
			), $component
		);?>
	<? $html = trim(ob_get_clean()); ?>

	<? // tags cloud left sidebar ?>
	<? if( $bShowLeftBlock ): ?>
		<?$this->__component->__template->SetViewTarget('under_sidebar_content');?>
			<?if($arSideInfo['TAGS']):?>
				<?= $html; ?>
			<?endif;?>
		<?$this->__component->__template->EndViewTarget();?>
	<? endif; ?>

	<?// show filter?>
	<?include('include/filter.php')?>
	
	<? // tags cloud tabs ?>
	<? if( !$bShowLeftBlock ): ?>
		<?= $html; ?>
	<? endif; ?>

	<?if (TSolution::checkAjaxRequest()):?>
		<?$APPLICATION->RestartBuffer()?>
	<?endif;?>

	<?$sViewElementsTemplate = ($arParams["SECTION_ELEMENTS_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["PROJECTS_PAGE"]["VALUE"] : $arParams["SECTION_ELEMENTS_TYPE_VIEW"]);?>
	<?@include_once('page_blocks/'.$sViewElementsTemplate.'.php');?>

	<?if (TSolution::checkAjaxRequest()):?>
		<?die()?>
	<?endif;?>

	<?if ($bUseMixLink):?>
		</div>
	<?endif;?>

<?endif;?>
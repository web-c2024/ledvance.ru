<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();?>
<?$this->setFrameMode(true);?>
<?
// get element
$arItemFilter = TSolution::GetCurrentElementFilter($arResult['VARIABLES'], $arParams);

global $APPLICATION, $arTheme;
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/css/animation/animate.min.css');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery.history.js');

$bShowLeftBlock = ($arTheme['LEFT_BLOCK_TARIFFS_DETAIL']['VALUE'] === 'Y' && !defined('ERROR_404'));
$APPLICATION->SetPageProperty('MENU', ($bShowLeftBlock ? 'Y' : 'N' ));

// cart
$bOrderViewBasket = (trim($arTheme['ORDER_VIEW']['VALUE']) === 'Y');

$arElement = TSolution\Cache::CIblockElement_GetList(
	array(
		'CACHE' => array(
			'TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']),
			'MULTI' => 'N'
		)
	), 
	TSolution::makeElementFilterInRegion($arItemFilter), 
	false, 
	false, 
	array('ID', 'IBLOCK_ID', 'IBLOCK_SECTION_ID')
);

//bug fix bitrix for search element
if ($arElement) {
	$strict_check = $arParams["DETAIL_STRICT_SECTION_CHECK"] === "Y";
	if(!CIBlockFindTools::checkElement($arParams["IBLOCK_ID"], $arResult["VARIABLES"], $strict_check))
		$arElement = array();
}
?>
<?if(TSolution::GetFrontParametrValue('TARIFFS_USE_DETAIL') !== 'Y'):?>
	<?TSolution::goto404Page();?>
<?else:?>
	<?if(!$arElement && $arParams['SET_STATUS_404'] !== 'Y'):?>
		<div class="alert alert-warning"><?=GetMessage("ELEMENT_NOTFOUND")?></div>
	<?elseif(!$arElement && $arParams['SET_STATUS_404'] === 'Y'):?>
		<?TSolution::goto404Page();?>
	<?else:?>
		<?TSolution::CheckComponentTemplatePageBlocksParams($arParams, __DIR__);?>
		
		<?// share top?>
		<?if($arParams['USE_SHARE'] === 'Y' && $arElement):?>
			<?$this->SetViewTarget('cowl_buttons');?>
			<?TSolution\Functions::showShareBlock(
				array(
					'CLASS' => 'top',
				)
			);?>
			<?$this->EndViewTarget();?>
		<?endif;?>

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
		
		<?TSolution::AddMeta(
			array(
				'og:description' => $arElement['PREVIEW_TEXT'],
				'og:image' => (($arElement['PREVIEW_PICTURE'] || $arElement['DETAIL_PICTURE']) ? CFile::GetPath(($arElement['PREVIEW_PICTURE'] ? $arElement['PREVIEW_PICTURE'] : $arElement['DETAIL_PICTURE'])) : false),
			)
		);?>
		<div class="detail detail-maxwidth <?=($templateName = $component->{'__template'}->{'__name'})?>" itemscope itemtype="http://schema.org/Service">
			<?
			// grupper
			$arParams['GRUPPER_PROPS'] = $arTheme['GRUPPER_PROPS']['VALUE'];
			if($arTheme['GRUPPER_PROPS']['VALUE'] != 'NOT'){
				$arParams["PROPERTIES_DISPLAY_TYPE"] = 'TABLE';

				if($arParams['GRUPPER_PROPS'] == 'GRUPPER' && !\Bitrix\Main\Loader::includeModule('redsign.grupper'))
					$arParams['GRUPPER_PROPS'] = 'NOT';
				if($arParams['GRUPPER_PROPS'] == 'WEBDEBUG' && !\Bitrix\Main\Loader::includeModule('webdebug.utilities'))
					$arParams['GRUPPER_PROPS'] = 'NOT';
				if($arParams['GRUPPER_PROPS'] == 'YENISITE_GRUPPER' && !\Bitrix\Main\Loader::includeModule('yenisite.infoblockpropsplus'))
					$arParams['GRUPPER_PROPS'] = 'NOT';
			}

			$arInherite = TSolution::getSectionInheritedUF(array(
				'sectionId' => $arElement['IBLOCK_SECTION_ID'],
				'iblockId' => $arElement['IBLOCK_ID'],
				'select' => array(
					'UF_DEFAULT_PRICE_KEY',
					'UF_DEFAULT_ITEM_NAME',
					'UF_DEFAULT_FALLBACK',
				),
				'filter' => array(
					'GLOBAL_ACTIVE' => 'Y', 
				),
				'enums' => array(
					'UF_DEFAULT_PRICE_KEY',
					'UF_DEFAULT_FALLBACK',
				),
			));

			$defaultPriceKey = TSolution\Functions::getValueWithSection([
				'CODE' => 'TARIFFS_DEFAULT_PRICE_KEY',
				'SECTION_VALUE' => $arInherite['UF_DEFAULT_PRICE_KEY'],
			]);

			$defaultItemName = TSolution\Functions::getValueWithSection([
				'CODE' => 'TARIFFS_DEFAULT_ITEM_NAME',
				'SECTION_VALUE' => $arInherite['UF_DEFAULT_ITEM_NAME'],
			]);

			$defaultFallback = TSolution\Functions::getValueWithSection([
				'CODE' => 'TARIFFS_DEFAULT_FALLBACK',
				'SECTION_VALUE' => $arInherite['UF_DEFAULT_FALLBACK'],
			]);

			//element
			$sViewElementTemplate = ($arParams["ELEMENT_TYPE_VIEW"] == "FROM_MODULE" ? $arTheme["TARIFFS_PAGE_DETAIL"]["VALUE"] : $arParams["ELEMENT_TYPE_VIEW"]);
			?>
			<div class="tariffs-detail js-popup-block">
				<?@include_once('page_blocks/'.$sViewElementTemplate.'.php');?>
			</div>
		</div>
		<?
		if (is_array($arElement['IBLOCK_SECTION_ID']) && count($arElement['IBLOCK_SECTION_ID']) > 1) {
			TSolution::CheckAdditionalChainInMultiLevel($arResult, $arParams, $arElement);
		}
		?>
	<?endif;?>
	<?
	if($arElement['IBLOCK_SECTION_ID']){
		$arSection = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array('TAG' => TSolution\Cache::GetIBlockCacheTag($arElement['IBLOCK_ID']), 'MULTI' => 'N')), array('ID' => $arElement['IBLOCK_SECTION_ID'], 'ACTIVE' => 'Y'), false, array('ID', 'NAME', 'SECTION_PAGE_URL'));
	}
	?>
	<div class="bottom-links-block<?=($arElement ? ' detail-maxwidth' : '')?>">
		<?// back url?>
		<?TSolution\Functions::showBackUrl(
			array(
				'URL' => ((isset($arSection) && $arSection) ? $arSection['SECTION_PAGE_URL'] : $arResult['FOLDER'].$arResult['URL_TEMPLATES']['news']),
				'TEXT' => ($arParams['T_PREV_LINK'] ? $arParams['T_PREV_LINK'] : GetMessage('BACK_LINK')),
			)
		);?>

		<?// share bottom?>
		<?if($arParams['USE_SHARE'] === 'Y' && $arElement):?>
			<?TSolution\Functions::showShareBlock(
				array(
					'CLASS' => 'bottom',
				)
			);?>
		<?endif;?>
	</div>
<?endif;?>
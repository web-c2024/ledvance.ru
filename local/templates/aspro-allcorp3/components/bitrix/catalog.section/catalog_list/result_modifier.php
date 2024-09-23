<?

use Bitrix\Main\Type\Collection;
use Bitrix\Currency\CurrencyTable;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/** @var CBitrixComponentTemplate $this */
/** @var array $arParams */
/** @var array $arResult */
$arDefaultParams = array(
	'TYPE_SKU' => 'N',
	'FILTER_HIT_PROP' => 'block',
	'OFFER_TREE_PROPS' => array('-'),
);
$arParams = array_merge($arDefaultParams, $arParams);
$bShowHintTextItem = in_array('INCLUDE_TEXT', $arParams['PROPERTY_CODE']);

if (!empty($arResult['ITEMS'])) {
	if ($bShowHintTextItem) {
		ob_start();
		$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			array(
				"AREA_FILE_SHOW" => "page",
				"AREA_FILE_SUFFIX" => "help_text",
				"EDIT_TEMPLATE" => ""
			)
		);
		$help_text = ob_get_contents();
		ob_end_clean();
		$bshowHelpTextFromFile = true;
		$arResult['INCLUDE_TEXT_FILE'] = false;
		if (strlen(trim($help_text)) < 1) {
			$bshowHelpTextFromFile = false;
		} else {
			$bIsBitrixDiv = (strpos($help_text, 'bx_incl_area') !== false);
			$textWithoutTags = strip_tags($help_text);
			if ($bIsBitrixDiv && (strlen(trim($textWithoutTags)) < 1)) {
				$bshowHelpTextFromFile = false;
			}
		}

		if ($bshowHelpTextFromFile) {
			$arResult['INCLUDE_TEXT'] = $help_text;
			$arResult['INCLUDE_TEXT_FILE'] = true;
		}
	}

	/* get sku tree props */
	$obSKU = new TSolution\SKU($arParams);
	if ($arParams['SKU_IBLOCK_ID'] && $arParams['SKU_TREE_PROPS']) {
		$obSKU->getTreePropsByFilter([
			'=IBLOCK_ID' => $arParams['SKU_IBLOCK_ID'],
			'CODE' => $arParams['SKU_TREE_PROPS']
		]);
		$arResult['SKU_CONFIG'] = $obSKU->config;
		$arResult['SKU_CONFIG']['ADD_PICT_PROP'] = $arParams['ADD_PICT_PROP'];
		$arResult['SKU_CONFIG']['SHOW_GALLERY'] = $arParams['SHOW_GALLERY'];
	}
	/* */

	/* get sections images */
	$arSections = TSolution\Product\Image::getSectionsImages([
		'ITEMS' => $arResult['ITEMS'],
	]);
	/* */

	$arNewItemsList = $arGoodsSectionsIDs = [];
	foreach ($arResult['ITEMS'] as $key => $arItem) {
		if (is_array($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'])) {
			$arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'] = reset($arItem['PROPERTIES']['CML2_ARTICLE']['VALUE']);
			$arResult['ITEMS'][$key]['PROPERTIES']['CML2_ARTICLE']['VALUE'] = $arItem['PROPERTIES']['CML2_ARTICLE']['VALUE'];
			if ($arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']) {
				$arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE'] = reset($arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE']);
				$arResult['ITEMS'][$key]['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE'] = $arItem['DISPLAY_PROPERTIES']['CML2_ARTICLE']['VALUE'];
			}
		}

		if ($arItem['DISPLAY_PROPERTIES']['DEMO_URL']) {
			$arProp = $arItem['DISPLAY_PROPERTIES']['DEMO_URL'];
			$arItem['DISPLAY_PROPERTIES']['DEMO_URL']['DISPLAY_VALUE'] = '<a rel="nofollow noopener" href="'.$arProp["VALUE"].'" target="_blank">'.$arProp["VALUE"].'</a>';
		}

		if (($arItem['DETAIL_PICTURE'] && $arItem['PREVIEW_PICTURE']) || (!$arItem['DETAIL_PICTURE'] && $arItem['PREVIEW_PICTURE'])) {
			$arItem['DETAIL_PICTURE'] = $arItem['PREVIEW_PICTURE'];
		}

		$arItem['GALLERY'] = TSolution\Functions::getSliderForItem([
			'TYPE' => 'catalog_block',
			'PROP_CODE' => $arParams['ADD_PICT_PROP'],
			// 'ADD_DETAIL_SLIDER' => false,
			'ITEM' => $arItem,
			'PARAMS' => $arParams,
		]);
		array_splice($arItem['GALLERY'], $arParams['MAX_GALLERY_ITEMS']);

		if (!empty($arItem['DISPLAY_PROPERTIES'])) {
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp) {
				if ('F' == $arDispProp['PROPERTY_TYPE']) {
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
			}
		}

		$arItem['ARTICLE'] = false;
		$arItem['PROPS'] = [];

		if (!empty($arItem['DISPLAY_PROPERTIES'])) {
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp) {
				if ($propKey == "CML2_ARTICLE") {
					$arItem['ARTICLE'] = $arDispProp;
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
				if ('F' == $arDispProp['PROPERTY_TYPE'] || $arDispProp["CODE"] == $arParams["STIKERS_PROP"]) {
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
			}
			$arItem['PROPS'] = TSolution::PrepareItemProps($arItem['DISPLAY_PROPERTIES']);
		}

		if ($arItem['IBLOCK_SECTION_ID']) {
			if ($arParams['SHOW_SECTION'] == 'Y' || $bShowHintTextItem) {
				$resGroups = CIBlockElement::GetElementGroups($arItem['ID'], true, array('ID'));
				while ($arGroup = $resGroups->Fetch()) {
					$arItem['SECTIONS'][$arGroup['ID']] = $arGroup['ID'];
					$arGoodsSectionsIDs[$arGroup['ID']] = $arGroup['ID'];
				}
			}

			/* get UF_INCLUDE_TEXT */
			if ($bShowHintTextItem) {
				$sectionHelpText = '';
				$sectionID = $arItem['SECTIONS'] ? reset($arItem['SECTIONS']) : $arItem['IBLOCK_SECTION_ID'];
				$arSection = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" => "N", "TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $sectionID, "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "IBLOCK_SECTION_ID", "DEPTH_LEVEL", "LEFT_MARGIN", "RIGHT_MARGIN", "UF_INCLUDE_TEXT"));

				if (strlen($arSection['UF_INCLUDE_TEXT'])) {
					$sectionHelpText = $arSection['UF_INCLUDE_TEXT'];
				}
				if (!$sectionHelpText) {
					if ($arSection["DEPTH_LEVEL"] > 2) {
						$arSectionParent = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" => "N", "TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "ID" => $arSection["IBLOCK_SECTION_ID"], "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "UF_INCLUDE_TEXT"));
						if (strlen($arSectionParent['UF_INCLUDE_TEXT'])) {
							$sectionHelpText = $arSectionParent['UF_INCLUDE_TEXT'];
						}

						if (!$sectionHelpText) {
							$arSectionRoot = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" => "N", "TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "<=LEFT_BORDER" => $arSection["LEFT_MARGIN"], ">=RIGHT_BORDER" => $arSection["RIGHT_MARGIN"], "DEPTH_LEVEL" => 1, "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "UF_INCLUDE_TEXT"));
							if (strlen($arSectionRoot['UF_INCLUDE_TEXT'])) {
								$sectionHelpText = $arSectionRoot['UF_INCLUDE_TEXT'];
							}
						}
					} else {
						$arSectionRoot = TSolution\Cache::CIBlockSection_GetList(array('CACHE' => array("MULTI" => "N", "TAG" => TSolution\Cache::GetIBlockCacheTag($arParams["IBLOCK_ID"]))), array('GLOBAL_ACTIVE' => 'Y', "<=LEFT_BORDER" => $arSection["LEFT_MARGIN"], ">=RIGHT_BORDER" => $arSection["RIGHT_MARGIN"], "DEPTH_LEVEL" => 1, "IBLOCK_ID" => $arParams["IBLOCK_ID"]), false, array("ID", "IBLOCK_ID", "UF_INCLUDE_TEXT"));
						if (strlen($arSectionRoot['UF_INCLUDE_TEXT'])) {
							$sectionHelpText = $arSectionRoot['UF_INCLUDE_TEXT'];
						}
					}
				}
			}
			/* */
		}

		if ($bShowHintTextItem) {
			if ($arItem['DISPLAY_PROPERTIES']['INCLUDE_TEXT']['~VALUE']) {
				$arItem['INCLUDE_TEXT'] = $arItem['DISPLAY_PROPERTIES']['INCLUDE_TEXT']['~VALUE']['TEXT'];
			} elseif ($sectionHelpText) {
				$arItem['INCLUDE_TEXT'] = $sectionHelpText;
			} elseif ($arResult['INCLUDE_TEXT_FILE']) {
				$arItem['INCLUDE_TEXT'] = $arResult['INCLUDE_TEXT'];
			}
		}

		$arItem['LAST_ELEMENT'] = 'N';

		/* get SKU for item */
		$obSKU->setLinkedPropFromDisplayProps($arItem['DISPLAY_PROPERTIES']);
		$obSKU->getItemsByProperty();
		$arItem['SKU'] = [
			'CURRENT' => $obSKU->currentItem,
			'OFFERS' => $obSKU->items,
			'PROPS' => $obSKU->treeProps
		];
		/* */

		/* replace no-image with section picture */
		if (
			$arParams["REPLACE_NOIMAGE_WITH_SECTION_PICTURE"]
			&& !$arItem['PREVIEW_PICTURE'] && !$arItem['DETAIL_PICTURE'] 
			&& ($arSections[$arItem['~IBLOCK_SECTION_ID']]['PICTURE']['src'] ?? false)
		) {
			$arPicture = TSolution\Product\Image::getPictureOrDetailPicture($arSections, $arItem);
			if (is_array($arPicture)) {
				$arItem['NO_IMAGE'] = [
					'ID' => $arPicture['id'],
					'SRC' => $arPicture['src'],
				];
			}
		}
		/* */

		$arNewItemsList[$key] = $arItem;
	}

	$arNewItemsList[$key]['LAST_ELEMENT'] = 'Y';
	$arResult['ITEMS'] = $arNewItemsList;

	unset($arNewItemsList);
	if ($arGoodsSectionsIDs) {
		$arGoodsSections = TSolution\Cache::CIBLockSection_GetList(array('CACHE' => array('TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N', 'RESULT' => array('NAME'))), array('ID' => $arGoodsSectionsIDs), false, array('ID', 'NAME'));
		foreach ($arResult['ITEMS'] as $key => $arItem) {
			if ($arItem['IBLOCK_SECTION_ID']) {
				foreach ($arItem['SECTIONS'] as $id => $name) {
					$arResult['ITEMS'][$key]['SECTIONS'][$id] = $arGoodsSections[$id];
				}
			}
		}
	}

	$arResult['CUSTOM_RESIZE_OPTIONS'] = array();
	if ($arParams['USE_CUSTOM_RESIZE_LIST'] == 'Y') {
		$arIBlockFields = CIBlock::GetFields($arParams["IBLOCK_ID"]);
		if ($arIBlockFields['PREVIEW_PICTURE'] && $arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE']) {
			if ($arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE']['WIDTH'] && $arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE']['HEIGHT']) {
				$arResult['CUSTOM_RESIZE_OPTIONS'] = $arIBlockFields['PREVIEW_PICTURE']['DEFAULT_VALUE'];
			}
		}
	}
}

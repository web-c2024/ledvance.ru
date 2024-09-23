<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$bShowSKU = $arParams['TYPE_SKU'] !== 'TYPE_2';

if ($arParams['SHOW_PROPS'] == 'Y') {
	$arParams['SHOW_GALLERY'] = 'N';
}



if (!empty($arResult['ITEMS'])) {
	/* get sku tree props */
	if ($bShowSKU) {
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
			$arItem['SHOW_PROPERTIES'] = TSolution::PrepareItemProps($arItem['DISPLAY_PROPERTIES']);
		}

		if ($arItem['SHOW_PROPERTIES']['DEMO_URL']) {
			$arProp = $arItem['SHOW_PROPERTIES']['DEMO_URL'];
			$arItem['SHOW_PROPERTIES']['DEMO_URL']['DISPLAY_VALUE'] = '<a rel="nofollow noopener" href="'.$arProp["VALUE"].'" target="_blank">'.$arProp["VALUE"].'</a>';
		}

		if ($arItem['IBLOCK_SECTION_ID'] && $arParams['SHOW_SECTION'] == 'Y') {
			$resGroups = CIBlockElement::GetElementGroups($arItem['ID'], true, array('ID'));
			while ($arGroup = $resGroups->Fetch()) {
				$arItem['SECTIONS'][$arGroup['ID']] = $arGroup['ID'];
				$arGoodsSectionsIDs[$arGroup['ID']] = $arGroup['ID'];
			}
		}


		$arItem['LAST_ELEMENT'] = 'N';

		/* get SKU for item */
		if ($bShowSKU) {
			$obSKU->setLinkedPropFromDisplayProps($arItem['DISPLAY_PROPERTIES']);
			// $obSKU->setSelectedItem(1996);
			$obSKU->getItemsByProperty();
			$arItem['SKU'] = [
				'CURRENT' => $obSKU->currentItem,
				'OFFERS' => $obSKU->items,
				'PROPS' => $obSKU->treeProps
			];
		}
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
?>
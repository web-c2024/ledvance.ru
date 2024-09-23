<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>

<?
$arParams['ITEMS_OFFSET'] = false;
$arParams['SHOW_GALLERY'] = 'N';
$arResult['SHOW_COLS_PROP'] = false;
$arResult['COLS_PROP'] = [];
$arResult['SHOW_IMAGE'] =  $bHideImg = true;
$arNewItemsList = [];

if (!empty($arResult['ITEMS'])) {
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

		if ($arItem['PREVIEW_PICTURE'] || $arItem['DETAIL_PICTURE']) {
			$bHideImg = false;
		}

		if (!empty($arItem['DISPLAY_PROPERTIES'])) {
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp) {
				if ('F' == $arDispProp['PROPERTY_TYPE']) {
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
			}
		}

		$arItem['ARTICLE']=false;
		$arItem['PROPS'] = [];

		if (!empty($arItem['DISPLAY_PROPERTIES'])) {
			foreach ($arItem['DISPLAY_PROPERTIES'] as $propKey => $arDispProp) {
				if ($propKey=="CML2_ARTICLE") {
					$arItem['ARTICLE']=$arDispProp;
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
				if ('F' == $arDispProp['PROPERTY_TYPE'] || $arDispProp["CODE"] == $arParams["STIKERS_PROP"]) {
					unset($arItem['DISPLAY_PROPERTIES'][$propKey]);
				}
			}
			$arItem['PROPS'] = TSolution::PrepareItemProps($arItem['DISPLAY_PROPERTIES']);

			if ($arItem['PROPS']) {
				$arResult['SHOW_COLS_PROP'] = true;
				foreach ($arItem['PROPS'] as $code => $arProp) {
					$arResult['COLS_PROP'][$code] = [
						'NAME' => $arProp['NAME'],
						'ID' => $arProp['ID'],
						'SORT' => $arProp['SORT']
					];
				}
			}
		}

		if ($arParams['REPLACED_DETAIL_LINK']) {
			$arItem['DETAIL_PAGE_URL'] = $arParams['REPLACED_DETAIL_LINK'];
			$oid = TSolution::GetFrontParametrValue('CATALOG_OID');
			if ($oid) {
				$arItem['DETAIL_PAGE_URL'] .= '?'.$oid.'='.$arItem['ID'];
			}
		}

		$arItem['LAST_ELEMENT'] = 'N';
		
		/* get SKU for item */
		$obSKU->setLinkedPropFromDisplayProps($arItem['DISPLAY_PROPERTIES']);
		// $obSKU->setSelectedItem(1996);
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

	if ($arResult['COLS_PROP']) {
		\Bitrix\Main\Type\Collection::sortByColumn($arResult['COLS_PROP'],[
			'SORT' => array(SORT_NUMERIC, SORT_ASC),
			'ID' => array(SORT_NUMERIC, SORT_ASC)
		], '', null, true);
	}

	if ($arParams['HIDE_NO_IMAGE'] === 'Y') {
		$arResult['SHOW_IMAGE'] = $bHideImg ? false : true;
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
}?>
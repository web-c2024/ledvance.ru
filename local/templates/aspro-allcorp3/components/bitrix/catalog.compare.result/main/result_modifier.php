<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Type\Collection;

$arParams['TYPE_SKU'] = 'N';

$arResult['ALL_FIELDS'] = array();
$existShow = !empty($arResult['SHOW_FIELDS']);
$existDelete = !empty($arResult['DELETED_FIELDS']);
if ($existShow || $existDelete) {
	if ($existShow) {
		foreach ($arResult['SHOW_FIELDS'] as $propCode) {
			$arResult['SHOW_FIELDS'][$propCode] = array(
				'CODE' => $propCode,
				'IS_DELETED' => 'N',
				'ACTION_LINK' => str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode);
		$arResult['ALL_FIELDS'] = $arResult['SHOW_FIELDS'];
		if ($arResult['ALL_FIELDS']["PREVIEW_PICTURE"] || $arResult['ALL_FIELDS']["DETAIL_PICTURE"])
			unset($arResult['ALL_FIELDS']["PREVIEW_PICTURE"], $arResult['ALL_FIELDS']["DETAIL_PICTURE"]);
	}
	if ($existDelete) {
		foreach ($arResult['DELETED_FIELDS'] as $propCode) {
			$arResult['ALL_FIELDS'][$propCode] = array(
				'CODE' => $propCode,
				'IS_DELETED' => 'Y',
				'ACTION_LINK' => str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode, $arResult['DELETED_FIELDS']);
	}
	Collection::sortByColumn($arResult['ALL_FIELDS'], array('SORT' => SORT_ASC));
}

$arResult['ALL_PROPERTIES'] = array();
$existShow = !empty($arResult['SHOW_PROPERTIES']);
$existDelete = !empty($arResult['DELETED_PROPERTIES']);

/* get sections images */
$arSections = TSolution\Product\Image::getSectionsImages([
	'ITEMS' => $arResult['ITEMS'],
]);
/* */

foreach ($arResult["ITEMS"] as $key => $arItem) {
	if ($arItem["DISPLAY_PROPERTIES"]) {
		foreach ($arItem["DISPLAY_PROPERTIES"] as $propCode => $arProp) {
			if ($arProp["VALUE"]) {
				$arResult["SHOW_PROPERTIES"][$propCode]["VALUE"] = $arProp["VALUE"];
			}
		}
	}

	if ($SID = $arItem['IBLOCK_SECTION_ID']) {
		$arSectionsIDs[] = $SID;
	}

	/* replace no-image with section picture */
	if (
		$arParams["REPLACE_NOIMAGE_WITH_SECTION_PICTURE"]
		&& !$arItem['PREVIEW_PICTURE'] && !$arItem['DETAIL_PICTURE'] 
		&& ($arSections[$arItem['~IBLOCK_SECTION_ID']]['PICTURE']['src'] ?? false)
	) {
		$arPicture = $arSections[$arItem['~IBLOCK_SECTION_ID']]['PICTURE'] ?? $arSections[$arItem['~IBLOCK_SECTION_ID']]['DETAIL_PICTURE'] ?? '';
		if (is_array($arPicture)) {
			$arResult['ITEMS'][$key]['NO_IMAGE'] = [
				'ID' => $arPicture['id'],
				'SRC' => $arPicture['src'],
			];
		}
	}
	/* */
}

$arResult["SHOW_PROPERTIES"] = TSolution::PrepareItemProps($arResult["SHOW_PROPERTIES"]);

if ($existShow || $existDelete) {
	if ($existShow) {
		foreach ($arResult['SHOW_PROPERTIES'] as $propCode => $arProp) {
			$arResult['SHOW_PROPERTIES'][$propCode]['IS_DELETED'] = 'N';
			$arResult['SHOW_PROPERTIES'][$propCode]['ACTION_LINK'] = str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_PROPERTY_TEMPLATE']);
		}
		$arResult['ALL_PROPERTIES'] = $arResult['SHOW_PROPERTIES'];
	}
	unset($arProp, $propCode);
	if ($existDelete) {
		foreach ($arResult['DELETED_PROPERTIES'] as $propCode => $arProp) {
			$arResult['DELETED_PROPERTIES'][$propCode]['IS_DELETED'] = 'Y';
			$arResult['DELETED_PROPERTIES'][$propCode]['ACTION_LINK'] = str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_PROPERTY_TEMPLATE']);
			$arResult['ALL_PROPERTIES'][$propCode] = $arResult['DELETED_PROPERTIES'][$propCode];
		}
		unset($arProp, $propCode, $arResult['DELETED_PROPERTIES']);
	}
	Collection::sortByColumn($arResult["ALL_PROPERTIES"], array('SORT' => SORT_ASC, 'ID' => SORT_ASC));
}

$arResult["ALL_OFFER_FIELDS"] = array();
$existShow = !empty($arResult["SHOW_OFFER_FIELDS"]);
$existDelete = !empty($arResult["DELETED_OFFER_FIELDS"]);
if ($existShow || $existDelete) {
	if ($existShow) {
		foreach ($arResult["SHOW_OFFER_FIELDS"] as $propCode) {
			if ($propCode == "PREVIEW_PICTURE" || $propCode == "DETAIL_PICTURE" || $propCode == "NAME" || $propCode == "ID") {
				unset($arResult["SHOW_OFFER_FIELDS"][$propCode]);
			} else {
				$arResult["SHOW_OFFER_FIELDS"][$propCode] = array(
					"CODE" => $propCode,
					"IS_DELETED" => "N",
					"ACTION_LINK" => str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_OF_FIELD_TEMPLATE']),
					'SORT' => $arResult['FIELDS_SORT'][$propCode]
				);
			}
		}
		unset($propCode);
		$arResult['ALL_OFFER_FIELDS'] = $arResult['SHOW_OFFER_FIELDS'];
	}
	if ($existDelete) {
		foreach ($arResult['DELETED_OFFER_FIELDS'] as $propCode) {
			$arResult['ALL_OFFER_FIELDS'][$propCode] = array(
				"CODE" => $propCode,
				"IS_DELETED" => "Y",
				"ACTION_LINK" => str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_OF_FIELD_TEMPLATE']),
				'SORT' => $arResult['FIELDS_SORT'][$propCode]
			);
		}
		unset($propCode, $arResult['DELETED_OFFER_FIELDS']);
	}
	Collection::sortByColumn($arResult['ALL_OFFER_FIELDS'], array('SORT' => SORT_ASC));
}

$arResult['ALL_OFFER_PROPERTIES'] = array();
$existShow = !empty($arResult["SHOW_OFFER_PROPERTIES"]);
$existDelete = !empty($arResult["DELETED_OFFER_PROPERTIES"]);
if ($existShow || $existDelete) {
	if ($existShow) {
		foreach ($arResult['SHOW_OFFER_PROPERTIES'] as $propCode => $arProp) {
			$arResult["SHOW_OFFER_PROPERTIES"][$propCode]["IS_DELETED"] = "N";
			$arResult["SHOW_OFFER_PROPERTIES"][$propCode]["ACTION_LINK"] = str_replace('#CODE#', $propCode, $arResult['~DELETE_FEATURE_OF_PROPERTY_TEMPLATE']);
		}
		unset($arProp, $propCode);
		$arResult['ALL_OFFER_PROPERTIES'] = $arResult['SHOW_OFFER_PROPERTIES'];
	}
	if ($existDelete) {
		foreach ($arResult['DELETED_OFFER_PROPERTIES'] as $propCode => $arProp) {
			$arResult["DELETED_OFFER_PROPERTIES"][$propCode]["IS_DELETED"] = "Y";
			$arResult["DELETED_OFFER_PROPERTIES"][$propCode]["ACTION_LINK"] = str_replace('#CODE#', $propCode, $arResult['~ADD_FEATURE_OF_PROPERTY_TEMPLATE']);
			$arResult['ALL_OFFER_PROPERTIES'][$propCode] = $arResult["DELETED_OFFER_PROPERTIES"][$propCode];
		}
		unset($arProp, $propCode, $arResult['DELETED_OFFER_PROPERTIES']);
	}
	Collection::sortByColumn($arResult['ALL_OFFER_PROPERTIES'], array('SORT' => SORT_ASC, 'ID' => SORT_ASC));
}

$arResult['SECTIONS'] = array();
if ($arParams["USE_COMPARE_GROUP"] === "Y") {
	if ($arSectionsIDs) {
		$arResult['SECTIONS'] = TSolution\Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => TSolution\Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), array('ID' => $arSectionsIDs, 'ACTIVE' => 'Y'), false, array("ID", "NAME", "IBLOCK_ID"));
	}
	foreach ($arResult['ITEMS'] as $arItem) {
		$SID = ($arItem['IBLOCK_SECTION_ID'] ? $arItem['IBLOCK_SECTION_ID'] : 0);
		if ($SID) {
			$arResult['SECTIONS'][$SID]['ITEMS'][$arItem['ID']] = $arItem;
		}
	}
} else {
	$arResult['SECTIONS'][0]['ITEMS'] = $arResult['ITEMS'];
	$arResult['SECTIONS'][0]['ID'] = '0';
}
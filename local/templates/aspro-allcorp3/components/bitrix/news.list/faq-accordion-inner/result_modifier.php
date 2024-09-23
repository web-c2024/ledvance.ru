<?php
foreach ($arResult['ITEMS'] as $arItem) {
	if (!$bLinkedMode) {
		if ($SID = $arItem['IBLOCK_SECTION_ID']) {
			$arSectionsIDs[] = $SID;
		}
	}
}

if ($arSectionsIDs) {
	$arResult['SECTIONS'] = CAllcorp3Cache::CIBLockSection_GetList(array('SORT' => 'ASC', 'NAME' => 'ASC', 'CACHE' => array('TAG' => CAllcorp3Cache::GetIBlockCacheTag($arParams['IBLOCK_ID']), 'GROUP' => array('ID'), 'MULTI' => 'N')), array('ID' => $arSectionsIDs));
}

if ($arResult['SECTIONS']) {
	$arItemSectionsIDs = array_column($arResult['SECTIONS'], 'ID');
}

foreach ($arResult['ITEMS'] as $arItem) {
	$SID = ($arItem['IBLOCK_SECTION_ID'] && !$bLinkedMode ? $arItem['IBLOCK_SECTION_ID'] : 0);

	if (in_array($arItem['IBLOCK_SECTION_ID'], $arItemSectionsIDs) || $bLinkedMode) {
		$arResult['SECTIONS'][$SID]['ITEMS'][$arItem['ID']] = $arItem;
	}
}

// unset empty sections
if (is_array($arResult['SECTIONS'])) {
	foreach ($arResult['SECTIONS'] as $i => $arSection) {
		if (!$arSection['ITEMS']) {
			unset($arResult['SECTIONS'][$i]);
		}
	}
}
?>
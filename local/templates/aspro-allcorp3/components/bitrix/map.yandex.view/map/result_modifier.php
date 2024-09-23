<?
global $arRegion;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);





if($arParams['USE_REGION_DATA'] == 'Y' && TSolution::GetFrontParametrValue('SHOW_REGION_CONTACT') == "Y" &&  $arRegion && $arRegion["PROPERTY_REGION_TAG_YANDEX_MAP_VALUE"])
{
	$arCoord = explode(",", $arRegion["PROPERTY_REGION_TAG_YANDEX_MAP_VALUE"]);
	$arResult['POSITION']['yandex_lat'] = $arCoord[0];
	$arResult['POSITION']['yandex_lon'] = $arCoord[1];

	$phones = '';
	if($arRegion['PHONES']) {
		foreach ($arRegion['PHONES'] as $phone) {
			$phones .= '<div class="value"><a class="dark_link" rel= "nofollow" href="'.$phone['HREF'].'">'.$phone['PHONE'].'</a></div>';
		}
	}

	$emails = '';
	if($arRegion['PROPERTY_EMAIL_VALUE']) {
		foreach ($arRegion['PROPERTY_EMAIL_VALUE'] as $email) {
			$emails .= '<a class="dark_link" href="mailto:' .$email. '">' .$email . '</a><br>';
		}
	}

	$metrolist = '';
	foreach ($arRegion['PROPERTY_METRO_VALUE'] as $metro) {
		$metrolist .= '<div class="metro"><i></i>'. $metro . '</div>';
	}

	$address = ($arItem['PROPERTY_ADDRESS_VALUE'] ? $arResult['PROPERTY_ADDRESS_VALUE'] : $arItem['NAME']);

	$popupOptions = [
		'ITEM' => [
			'NAME' => $address,
			'EMAIL' => $arRegion['PROPERTY_EMAIL_VALUE'],
			'EMAIL_HTML' => $emails,
			'PHONE' => $arRegion['PHONES'],
			'PHONE_HTML' => $phones,
			'METRO' => $arRegion['PROPERTY_METRO_VALUE'],
			'METRO_HTML' => $metrolist,
			'SCHEDULE' => $arRegion['PROPERTY_SHCEDULE_VALUE']['TEXT'] ?? '',
			'DISPLAY_PROPERTIES' => [
				'METRO' => [
					'NAME' => Loc::getMessage('MYMS_TPL_METRO'),
				],
				'SCHEDULE' => [
					'NAME' => Loc::getMessage('MYMS_TPL_SCHEDULE'),
				],
				'PHONE' => [
					'NAME' =>  Loc::getMessage('MYMS_TPL_PHONE'),
				],
				'EMAIL' => [
					'NAME' => Loc::getMessage('MYMS_TPL_EMAIL'),
				]
			]
		],
		'PARAMS' => [
			'TITLE' => '',
			'BTN_CLASS' => '',
		],
		'SHOW_QUESTION_BTN' => 'Y',
		'SHOW_SOCIAL' => 'N',
		'SHOW_CLOSE' => 'N',
		'SHOW_TITLE' => 'N',
	];

	$arResult['POSITION']['PLACEMARKS'] = array(
		array(
			"LON" => $arResult['POSITION']['yandex_lon'],
			"LAT" => $arResult['POSITION']['yandex_lat'],
			"TEXT" => TSolution\Functions::getItemMapHtml($popupOptions),
		)
	);
}
?>
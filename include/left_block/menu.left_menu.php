<?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"left",
	array(
		"CACHE_SELECTED_ITEMS" => "Y",
		"ROOT_MENU_TYPE" => "left",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_USE_GROUPS" => "N",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => TSolution::GetFrontParametrValue('MAX_DEPTH_MENU'),
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "Y",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "Y",
		"COMPONENT_TEMPLATE" => "left"
	),
	false, ['HIDE_ICONS' => 'N']
);?>
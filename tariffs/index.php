<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тарифы");
?><?$APPLICATION->IncludeComponent(
	"bitrix:news", 
	"tariffs", 
	array(
		"ADD_ELEMENT_CHAIN" => "Y",
		"ADD_SECTIONS_CHAIN" => "Y",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BIG_GALLERY_PROP_CODE" => "-",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"DETAIL_BLOCKS_ALL_ORDER" => "desc,char,docs,reviews,sale,services,partners,projects,news,articles,faq,goods,buy,payment,dops,comments",
		"DETAIL_BLOCKS_ORDER" => "tabs,sale,services,partners,projects,news,articles,goods,comments",
		"DETAIL_BLOCKS_TAB_ORDER" => "desc,char,docs,faq,reviews,buy,payment,dops",
		"DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
		"DETAIL_DISPLAY_TOP_PAGER" => "N",
		"DETAIL_FIELD_CODE" => array(
			0 => "PREVIEW_TEXT",
			1 => "PREVIEW_PICTURE",
			2 => "DETAIL_TEXT",
			3 => "DETAIL_PICTURE",
			4 => "",
		),
		"DETAIL_PAGER_SHOW_ALL" => "Y",
		"DETAIL_PAGER_TEMPLATE" => "",
		"DETAIL_PAGER_TITLE" => "",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "FORM_QUESTION",
			1 => "FORM_ORDER",
			2 => "HIT",
			3 => "PRICE_CURRENCY",
			4 => "FILTER_PRICE_1",
			5 => "TARIF_PRICE_1",
			6 => "FILTER_PRICE_2",
			7 => "TARIF_PRICE_2",
			8 => "TARIF_PRICE_2_DISC",
			9 => "TARIF_PRICE_2_ECONOMY",
			10 => "TARIF_PRICE_2_ONE",
			11 => "FILTER_PRICE_3",
			12 => "TARIF_PRICE_3",
			13 => "TARIF_PRICE_3_DISC",
			14 => "TARIF_PRICE_3_ECONOMY",
			15 => "TARIF_PRICE_3_ONE",
			16 => "FILTER_PRICE_DEFAULT",
			17 => "TARIF_PRICE_DEFAULT",
			18 => "TARIF_PRICE_DEFAULT_DISC",
			19 => "TARIF_PRICE_DEFAULT_ECONOMY",
			20 => "TARIF_PRICE_DEFAULT_ONE",
			21 => "MULTI_PROP",
			22 => "PHOTOPOS",
			23 => "LINK_FAQ",
			24 => "LINK_NEWS",
			25 => "LINK_ARTICLES",
			26 => "LINK_SERVICES",
			27 => "LINK_GOODS_FILTER",
			28 => "LINK_GOODS",
			29 => "LINK_PROJECTS",
			30 => "LINK_REVIEWS",
			31 => "LINK_SALE",
			32 => "SUPPLIED",
			33 => "USERS",
			34 => "EXTENSION",
			35 => "DURATION",
			36 => "GROUPS_USERS",
			37 => "ADMIN",
			38 => "VOLUME",
			39 => "FILE_STORAGE",
			40 => "MEMORY",
			41 => "CPU",
			42 => "IP",
			43 => "HOSTING_SITES",
			44 => "KOLLICHESTVO_BAZ_DANNIX",
			45 => "ZADACHI",
			46 => "NAGRUZKA",
			47 => "ONLY_ONE_PRICE",
			48 => "PRICE",
			49 => "PRICEOLD",
			50 => "ECONOMY",
			51 => "LINK_STAFF",
			52 => "LINK_VACANCY",
			53 => "VIDEO_IFRAME",
			54 => "VIDEO",
			55 => "LINK_PARTNERS",
			56 => "LINK_TIZERS",
			57 => "AUTHOR_CONTROL",
			58 => "PROP2",
			59 => "DISEGHNER_AT_PLACE",
			60 => "FOR_SHOW_1",
			61 => "FOR_SHOW_5",
			62 => "MATERIAL_PICK",
			63 => "FOR_SHOW_2",
			64 => "FOR_SHOW_3",
			65 => "FOR_SHOW_4",
			66 => "FOR_SHOW_6",
			67 => "TYPE_OF_BUILD",
			68 => "LINK_STUDY",
			69 => "FOR_SHOW_7",
			70 => "FOR_SHOW_8",
			71 => "DOCUMENTS",
			72 => "PHOTOS",
			73 => "STATUS",
			74 => "ARTICLE",
			75 => "DATE_COUNTER",
			76 => "MULTI_PROP_BOTTOM_PROPS",
			77 => "TASK",
			78 => "ONLINE",
			79 => "MESSAGE",
			80 => "UPDATES",
			81 => "LANGUAGES",
			82 => "TARIF_PRICE_1_DISC",
			83 => "TARIF_PRICE_4",
			84 => "ICON",
			85 => "VISA",
			86 => "NUM_DEVICES",
			87 => "APPLE",
			88 => "ELPURSE",
			89 => "API_INTEGRATION",
			90 => "SIEM_SYSTEM",
			91 => "COLLECT_INFO",
			92 => "RULES_SIGNAT",
			93 => "SCANNER",
			94 => "ANTIVIRUS",
			95 => "PROTECT_PAYMENT",
			96 => "PROTECT_CAMERA",
			97 => "ANTIVOR",
			98 => "CONTROL",
			99 => "SUPPORT_FREE",
			100 => "GUARANTEE",
			101 => "BLOCKING_SITES",
			102 => "BLOCKING_TRAFFIC",
			103 => "SECURITY",
			104 => "PROTECT_CHILDREN",
			105 => "SUM_FINANCING",
			106 => "TERM_LEASING",
			107 => "INSURANCE",
			108 => "CURRENCY",
			109 => "ADVANCE_PAY",
			110 => "RATE",
			111 => "PERCENTAGE",
			112 => "PAYMENTS",
			113 => "SUPPORT",
			114 => "NOTIFICATION",
			115 => "TURN",
			116 => "TARIF_ITEM",
			117 => "",
		),
		"DETAIL_SET_CANONICAL_URL" => "N",
		"DETAIL_USE_COMMENTS" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"DOCS_PROP_CODE" => "-",
		"ELEMENT_TYPE_VIEW" => "element_1",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "35",
		"IBLOCK_TYPE" => "aspro_allcorp3_catalog",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "A",
		"LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
		"LIST_FIELD_CODE" => array(
			0 => "ID",
			1 => "NAME",
			2 => "PREVIEW_TEXT",
			3 => "PREVIEW_PICTURE",
			4 => "DETAIL_PICTURE",
			5 => "",
		),
		"LIST_PROPERTY_CODE" => array(
			0 => "FORM_ORDER",
			1 => "HIT",
			2 => "PRICE_CURRENCY",
			3 => "TARIF_PRICE_1",
			4 => "TARIF_PRICE_2",
			5 => "TARIF_PRICE_2_DISC",
			6 => "TARIF_PRICE_3",
			7 => "TARIF_PRICE_3_DISC",
			8 => "TARIF_PRICE_DEFAULT",
			9 => "TARIF_PRICE_DEFAULT_DISC",
			10 => "MULTI_PROP",
			11 => "SUPPLIED",
			12 => "USERS",
			13 => "EXTENSION",
			14 => "DURATION",
			15 => "GROUPS_USERS",
			16 => "ADMIN",
			17 => "VOLUME",
			18 => "FILE_STORAGE",
			19 => "MEMORY",
			20 => "CPU",
			21 => "IP",
			22 => "HOSTING_SITES",
			23 => "KOLLICHESTVO_BAZ_DANNIX",
			24 => "ZADACHI",
			25 => "NAGRUZKA",
			26 => "ONLY_ONE_PRICE",
			27 => "MULTI_PROP_BOTTOM_PROPS",
			28 => "TASK",
			29 => "ONLINE",
			30 => "MESSAGE",
			31 => "UPDATES",
			32 => "LANGUAGES",
			33 => "TARIF_PRICE_1_DISC",
			34 => "TARIF_PRICE_4",
			35 => "ICON",
			36 => "VISA",
			37 => "NUM_DEVICES",
			38 => "APPLE",
			39 => "ELPURSE",
			40 => "API_INTEGRATION",
			41 => "SIEM_SYSTEM",
			42 => "COLLECT_INFO",
			43 => "RULES_SIGNAT",
			44 => "SCANNER",
			45 => "ANTIVIRUS",
			46 => "PROTECT_PAYMENT",
			47 => "PROTECT_CAMERA",
			48 => "ANTIVOR",
			49 => "CONTROL",
			50 => "SUPPORT_FREE",
			51 => "GUARANTEE",
			52 => "BLOCKING_SITES",
			53 => "BLOCKING_TRAFFIC",
			54 => "SECURITY",
			55 => "PROTECT_CHILDREN",
			56 => "SUM_FINANCING",
			57 => "TERM_LEASING",
			58 => "INSURANCE",
			59 => "CURRENCY",
			60 => "ADVANCE_PAY",
			61 => "RATE",
			62 => "PERCENTAGE",
			63 => "PAYMENTS",
			64 => "SUPPORT",
			65 => "NOTIFICATION",
			66 => "TURN",
			67 => "TARIF_ITEM",
			68 => "",
		),
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "main",
		"PAGER_TITLE" => "Новости",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SECTIONS_TYPE_VIEW" => "FROM_MODULE",
		"SECTION_ELEMENTS_TYPE_VIEW" => "FROM_MODULE",
		"SECTION_TYPE_VIEW" => "FROM_MODULE",
		"SEF_FOLDER" => "/tariffs/",
		"SEF_MODE" => "Y",
		"SET_LAST_MODIFIED" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"SHOW_404" => "Y",
		"SHOW_BIG_GALLERY" => "Y",
		"SHOW_BUY" => "N",
		"SHOW_CHILD_ELEMENTS" => "Y",
		"SHOW_CHILD_SECTIONS" => "Y",
		"SHOW_DELIVERY" => "N",
		"SHOW_DETAIL_LINK" => "Y",
		"SHOW_DOPS" => "Y",
		"SHOW_PAYMENT" => "N",
		"SHOW_SECTION" => "Y",
		"SHOW_SECTION_DESCRIPTION" => "Y",
		"SHOW_SECTION_PREVIEW_DESCRIPTION" => "Y",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "Y",
		"T_ARTICLES" => "",
		"T_BIG_GALLERY" => "",
		"T_CHAR" => "",
		"T_COMMENTS" => "comm",
		"T_DESC" => "",
		"T_DOCS" => "",
		"T_FAQ" => "",
		"T_GOODS" => "Вам может понравиться",
		"T_NEWS" => "",
		"T_PARTNERS" => "",
		"T_PROJECTS" => "",
		"T_REVIEWS" => "",
		"T_SALE" => "",
		"T_SERVICES" => "",
		"T_STAFF" => "",
		"T_VACANCY" => "",
		"T_VIDEO" => "",
		"USE_CATEGORIES" => "N",
		"USE_FILTER" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_RATING" => "N",
		"USE_RSS" => "N",
		"USE_SEARCH" => "N",
		"USE_SHARE" => "Y",
		"COMPONENT_TEMPLATE" => "tariffs",
		"TYPE_BIG_GALLERY" => "SMALL",
		"USE_DETAIL_TABS" => "FROM_MODULE",
		"S_ASK_QUESTION" => "",
		"S_ORDER_SERVISE" => "",
		"FORM_ID_ORDER_SERVISE" => "",
		"T_DOPS" => "",
		"DETAIL_BLOG_USE" => "N",
		"DETAIL_BLOG_URL" => "catalog_comments",
		"COMMENTS_COUNT" => "5",
		"DETAIL_BLOG_TITLE" => "Комментарии",
		"DETAIL_BLOG_EMAIL_NOTIFY" => "N",
		"DETAIL_VK_USE" => "Y",
		"DETAIL_FB_USE" => "Y",
		"PROPERTIES_DISPLAY_TYPE" => "TABLE",
		"DETAIL_VK_TITLE" => "ВКонтакте",
		"DETAIL_VK_API_ID" => "API_ID",
		"DETAIL_FB_TITLE" => "Facebook",
		"DETAIL_FB_APP_ID" => "APP_ID",
		"DETAIL_USE_TAGS" => "N",
		"SHOW_CATEGORY" => "N",
		"SHOW_ELEMENTS_IN_LAST_SECTION" => "Y",
		"SECTIONS_ITEMS_OFFSET" => "Y",
		"SECTIONS_ELEMENTS_COUNT" => "2",
		"SECTION_ITEMS_OFFSET" => "Y",
		"SECTION_ELEMENTS_COUNT" => "2",
		"SECTION_IMAGE_POSITION" => "RIGHT",
		"LIST_VISIBLE_PROP_COUNT" => "5",
		"DETAIL_VISIBLE_PROP_COUNT" => "6",
		"SEF_URL_TEMPLATES" => array(
			"news" => "",
			"section" => "#SECTION_CODE_PATH#/",
			"detail" => "#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
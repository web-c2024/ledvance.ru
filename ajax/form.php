<?
define("STATISTIC_SKIP_ACTIVITY_CHECK", "true");
define('STOP_STATISTICS', true);
define('PUBLIC_AJAX_MODE', true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/vendor/php/solution.php');


$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$form_id = htmlspecialcharsbx($request['form_id']) ?? false;
$type = htmlspecialcharsbx($request['type']) ?? false;
$id = htmlspecialcharsbx($request['id']) ?? false;

if(\Bitrix\Main\Loader::includeModule(TSolution::moduleID))
	$arTheme = TSolution::GetFrontParametrsValues(SITE_ID);
$isCallBack = (TSolution::GetFrontParametrValue('USE_BITRIX_FORM') == 'N') && ($id == TSolution\Cache::$arIBlocks[SITE_ID]["aspro_".VENDOR_SOLUTION_NAME."_form"]["aspro_".VENDOR_SOLUTION_NAME."_callback"][0]);
$successMessage = ($isCallBack ? "<p>Наш менеджер перезвонит вам в ближайшее время.</p><p>Спасибо за ваше обращение!</p>" : "Ваше сообщение отправлено!");
?>
<span class="jqmClose top-close stroke-theme-hover" onclick="window.b24form = false;" title="<?=\Bitrix\Main\Localization\Loc::getMessage('CLOSE_BLOCK');?>"><?=TSolution::showIconSvg('', SITE_TEMPLATE_PATH.'/images/svg/Close.svg')?></span>
<?if($form_id === 'fast_view'):?>
	<?include('fast_view.php');?>
<?elseif($form_id === 'fast_view_sale'):?>
	<?include('fast_view_sale.php');?>
<?elseif($form_id === 'marketing'):?>
	<?include('marketing.php');?>
<?elseif($form_id === 'city_chooser'):?>
	<?include_once('city_chooser.php');?>
<?elseif($type === 'review'):?>
	<?include_once('review.php');?>
<?elseif($type === 'auth'):?>
	<?include_once('auth.php');?>
<?elseif($type === 'subscribe'):?>
	<?include('subscribe.php');?>
<?elseif($form_id == 'TABLES_SIZE'):?>
	<?$url_sizes = htmlspecialcharsbx(isset($request['url']) && $request['url'] ? $_SERVER['DOCUMENT_ROOT'] . $request['url'] : '');?>
	<?if(
		$url_sizes &&
		strpos(realpath($url_sizes), $_SERVER['DOCUMENT_ROOT'].$arTheme['CATALOG_PAGE_URL']) === 0 &&
		file_exists($url_sizes)
	):?>
		<link href="<?=SITE_TEMPLATE_PATH?>/css/fonts/font-awesome/css/font-awesome.min.css"  rel="stylesheet" />
		<a href="#" class="close jqmClose"></a>
		<div class="form popup">
			<div class="form-head">
				<h2><?=\Bitrix\Main\Localization\Loc::getMessage('TABLES_SIZE_TITLE');?></h2>
			</div>
			<div class="form-body">
				<?include($url_sizes);?>
			</div>
		</div>
	<?endif;?>
<?elseif($id):?>
	<?$APPLICATION->IncludeComponent(
		"aspro:form.".VENDOR_SOLUTION_NAME, "popup",
		Array(
			"IBLOCK_TYPE" => "aspro_".VENDOR_SOLUTION_NAME."_form",
			"IBLOCK_ID" => $id,
			"AJAX_MODE" => "Y",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "N",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "100000",
			"AJAX_OPTION_ADDITIONAL" => "",
			"SUCCESS_MESSAGE" => $successMessage,
			"SEND_BUTTON_NAME" => "Отправить",
			"SEND_BUTTON_CLASS" => "btn btn-default",
			"DISPLAY_CLOSE_BUTTON" => "Y",
			"POPUP" => "Y",
			"CLOSE_BUTTON_NAME" => "Закрыть",
			"CLOSE_BUTTON_CLASS" => "jqmClose btn btn-default bottom-close"
		)
	);?>
<?else:?>
	<div style="padding: 40px 40px 15px 40px;">
		<div class="alert alert-danger">
			<?=\Bitrix\Main\Localization\Loc::getMessage('ERROR_ID_FORM');?>
		</div>
	</div>
<?endif;?>
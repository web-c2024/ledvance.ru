<?@include_once('under_footer_custom.php');?>
<?include_once('under_footer_solution.php');?>

<!-- marketnig popups -->
<?$APPLICATION->IncludeComponent(
	"aspro:marketing.popup.".VENDOR_SOLUTION_NAME, 
	".default", 
	array(),
	false, array('HIDE_ICONS' => 'Y')
);?>
<!-- /marketnig popups -->

<div class="bx_areas"><?TSolution::ShowPageType('bottom_counter');?></div>
<?TSolution::SetMeta();?>
<?TSolution::ShowPageType('search_title_component');?>
<?TSolution::ShowPageType('basket_component');?>
<?TSolution\Functions::showBottomPanel();?>
<?TSolution::AjaxAuth();?>
<div id="popup_iframe_wrapper"></div>
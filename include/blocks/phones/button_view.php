<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];

if (!$arOptions['DATASET']) return;

$bShowWrapper = !!trim($arOptions['WRAPPER_CLASS']);
?>

<?if ($bShowWrapper):?>
<div class="<?=$arOptions['WRAPPER_CLASS'];?>">
<?endif;?>

	<button type="button" 
		class="animate-load btn btn-default btn-wide<?=$arOptions['ADDITIONAL_CLASS'];?>" 
		data-event="jqm" 
		data-param-id="<?=$arOptions['DATASET']['PARAM_ID'];?>" 
		data-name="<?=$arOptions['DATASET']['NAME'];?>"
	>
		<?=$arOptions['TEXT'];?>
	</button>

<?if ($bShowWrapper):?>
</div>
<?endif;?>
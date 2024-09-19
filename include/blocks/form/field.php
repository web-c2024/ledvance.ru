<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="<?=$arOptions['QUESTION_CLASS_LIST'];?>" 
	 data-SID="<?=$arOptions['DATA_SID'];?>"
>
	<div class="form-group<?=$arOptions['FORM_GROUP_CLASS_LIST'];?>">
		<?=$arOptions['CAPTION'];?>
		
		<div class="input<?=$arOptions['HTML_CODE_WRAPPER_CLASS_LIST'];?>">
			<?=$arOptions['HTML_CODE'];?>
			
			<?if ($arOptions['IS_FILE_MULTIPLE']):?>
				<div class="add_file color-theme">
					<span><?=GetMessage('JS_FILE_ADD');?></span>
				</div>
			<?endif;?>
		</div>

		<?if ($arOptions['HINT']):?>
			<div class="hint"><?=$arOptions["HINT"];?></div>
		<?endif;?>
	</div>
</div>
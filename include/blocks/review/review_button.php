<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];

$file = SITE_DIR.'include/reviews.php';
$fileDocumentRoot = str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].$file);
$hasReviewFile = file_exists($fileDocumentRoot) && !!strlen(trim(file_get_contents($fileDocumentRoot)));
?>
<div class="reviews-info">
	<div class="reviews-info__top">
		<div class="reviews-info__line">
			<?if ($hasReviewFile):?>
				<div class="reviews-info__col">
					<div class="reviews-info__icon">
						<?=TSolution::showIconSvg('review stroke-theme', SITE_TEMPLATE_PATH . '/images/svg/review_bubble_large.svg');?>
					</div>
					
					<div class="reviews-info__text">
						<?$APPLICATION->IncludeFile($file, [], [
							'MODE' => 'text',
							'NAME' => $arOptions['DESCRIPTION'],
							'TEMPLATE' => 'include_area.php',
						]);?>
					</div>
				</div>
			<?endif; ?>
			<div class="reviews-info__col">
				<div class="reviews-info__btn-wrapper<?=!$hasReviewFile ? ' reviews-info__btn-wrapper--singleton' : '';?>">
					<div>
						<div class="btn btn-default btn btn-default animate-load has-ripple animate-load"
							 data-event="jqm"
							 data-name="<?=$arOptions['FORM_ID'];?>"
							 data-hide-specialist=""
							 data-param-id="<?=TSolution::getFormID($arOptions['FORM_ID']);?>"
							 <?=$arOptions['STAFF_ID'] ? 'data-autoload-specialist="'.$arOptions['STAFF_ID'].'"' : '';?>
						>
							<?=$arOptions['BUTTON_TITLE'];?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

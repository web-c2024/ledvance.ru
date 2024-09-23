<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();
$this->setFrameMode(true);
use \Bitrix\Main\Localization\Loc;

global $arTheme;
?>
<?if($arResult):?>
	<?
	$blockClasses = '';

	$owlClasses = ' owl-carousel--light owl-carousel--buttons-bordered owl-carousel--button-wide owl-carousel--items-'.$arParams['ELEMENTS_ROW'];
	if($arParams['NARROW']) {
		$owlClasses .= ' owl-carousel--button-offset-half';
	}
	else{
		$owlClasses .= ' owl-carousel--button-offset-none';
	}

	$itemWrapperClasses = ' grid-list__item';
	if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']){
		$itemWrapperClasses .= ' grid-list-border-outer';
	}
	if($bItemsTypeAlbums){
		$itemWrapperClasses .= ' stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover';
	}

	$itemClasses = 'height-100 flexbox dark-block-hover gallery-list__item--has-additional-text gallery-list__item--has-bg gallery-list__item--photos';
	$imageWrapperClasses = 'gallery-list__item-image-wrapper--PICTURES gallery-list__item-image-wrapper--BG';
	$imageClasses = 'rounded-4';
	?>
	<div class="gallery-item <?=$blockClasses?> <?=$templateName?>-template">
		<?if($arParams['NARROW']):?>
			<div class="maxwidth-theme">
		<?endif;?>

		<?//need for showed left block?>
		<div class="flexbox flexbox--direction-row flexbox--column-t991">
			<?=TSolution\Functions::showTitleInLeftBlock([
				'PARAMS' => array_merge($arParams, [
					'TITLE' => $arResult['NAME'],
					'PREVIEW_TEXT' => $arResult['PREVIEW_TEXT'],
				]),
			]);?>

			<div class="flex-grow-1">
				<?if($arResult['PROPERTIES']['PHOTOS']['VALUE']):?>
					<div class="owl-carousel <?=$owlClasses?>" data-plugin-options='{"nav": true, "rewind": true, "dots": true, "dotsContainer": false, "loop": false, "autoplay": false, "marginMove": true, "margin": 0, "responsive" : {"0": {"items": 1} }}'>
						<?foreach($arResult['PROPERTIES']['PHOTOS']['VALUE'] as $photoId):?>
							<?
							$arImage = CFile::GetFileArray($photoId);
							$imageSrc = $arImage['SRC'];
							$imageDescr = $arImage['DESCRIPTION'];
							?>
							<div class="gallery-list__wrapper <?=$itemWrapperClasses?>">
								<div class="gallery-list__item <?=$itemClasses?>">
									<div class="gallery-list__item-image-wrapper <?=$imageWrapperClasses?>">
										<a class="gallery-list__item-link" href="javascript:void(0);" title="<?=htmlspecialcharsbx($imageDescr)?>" data-big="<?=$imageSrc?>">
											<span class="gallery-list__item-image <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
										</a>
									</div>

									<div class="gallery-list__item-text-wrapper flexbox ">
										<div class="gallery-list__item-text-cross-part animate-cross-hover">
											<div class="cross cross--wide42"></div>
										</div>
									</div>
								</div>
							</div>
						<?endforeach;?>
					</div>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['NARROW']):?>
			</div>
		<?endif;?>
	</div>
<?endif;?>
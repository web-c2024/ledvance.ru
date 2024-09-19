<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

//options from \Aspro\Functions\CAsproAllcorp3::showBlockHtml
$arOptions = $arConfig['PARAMS'];
$arGallery = $arOptions['GALLERY'];
$arBlocks = $arOptions['BLOCKS'];

$defaultImageSRC = $arOptions['TOTAL_COUNT'] ? reset($arGallery)['SRC']['BIG'] : $arBlocks['NO_IMAGE']['SRC'];
?>
<?if ($arBlocks['STICKERS'] && $arBlocks['STICKERS']['POSITION'] === 'outer'):?>
	<?=$arBlocks['STICKERS']['HTML'];?>
<?endif;?>

<div class="catalog-detail__gallery swipeignore image-list__link<?=$arOptions['CLASS']['CONTAINER'] ?? '';?>">
	<?if ($arOptions['SKU_IMG_CONFIG']):?>
	<div class="js-config-img" data-img-config='<?=$arOptions['SKU_IMG_CONFIG'];?>'></div>
	<?endif;?>
	<?if ($arOptions['INNER_WRAPPER']):?>
		<div class="<?=$arOptions['INNER_WRAPPER'];?>">
	<?endif;?>
	
	<?if ($arBlocks['STICKERS'] && $arBlocks['STICKERS']['POSITION'] === 'container'):?>
		<?=$arBlocks['STICKERS']['HTML'];?>
	<?endif;?>
	
	<div class="catalog-detail__gallery-wrapper">
		<?if ($arBlocks['STICKERS'] && $arBlocks['STICKERS']['POSITION'] === 'wrapper'):?>
			<?if ($arBlocks['STICKERS']['WRAPPER']):?>
				<div class="<?=$arBlocks['STICKERS']['WRAPPER'];?>">
			<?endif;?>

				<?=$arBlocks['STICKERS']['HTML'];?>

			<?if ($arBlocks['STICKERS']['WRAPPER']):?>
				<?if ($arBlocks['POPUP_VIDEO']):?>
					<?=$arBlocks['POPUP_VIDEO']['HTML'];?>
				<?endif;?>

				</div>
			<?endif;?>
		<?endif;?>

		<link href="<?=$defaultImageSRC;?>" itemprop="image"/>
		<div class="catalog-detail__gallery-slider big owl-carousel owl-carousel--outer-dots owl-carousel--nav-hover-visible owl-bg-nav owl-carousel--light owl-carousel--button-wide owl-carousel--button-offset-half js-detail-img" 
			data-plugin-options='<?=$arOptions['SLIDER']['CONFIG'];?>'>
			<?$iSuffix = \Bitrix\Main\Security\Random::getInt();?>						
			<?if ($arOptions['TOTAL_COUNT']):?>
				<?foreach ($arGallery as $index => $arImage):?>
					<div id="big-photo-<?=$index;?>" class="catalog-detail__gallery__item catalog-detail__gallery__item--big">
						<a href="<?=$arImage['SRC']['BIG'];?>" data-fancybox="gallery_<?=$iSuffix;?>" class="catalog-detail__gallery__link popup_link fancy" title="<?=$arImage['TITLE'];?>">
							<img class="catalog-detail__gallery__picture" 
								 src="<?=$arImage['SRC']['SMALL'];?>" 
								 alt="<?=$arImage['ALT'];?>" 
								 title="<?=$arImage['TITLE'];?>" 
							>
						</a>
					</div>
				<?endforeach;?>
			<?else:?>
				<div class="catalog-detail__gallery__item catalog-detail__gallery__item--big<?=!$arBlocks['NO_IMAGE']['FANCY'] ? ' catalog-detail__gallery__item--no-image' : '';?>">
					<?if ($arBlocks['NO_IMAGE']['FANCY']):?>
					<a href="<?=$arBlocks['NO_IMAGE']['SRC'];?>" class="catalog-detail__gallery__link popup_link fancy" data-fancybox="gallery_<?=$iSuffix;?>">
					<?else:?>
					<span class="catalog-detail__gallery__link">
					<?endif;?>
						<?=$arBlocks['NO_IMAGE']['HTML'];?>
					<?if ($arBlocks['NO_IMAGE']['FANCY']):?>
					</a>
					<?else:?>
					</span>
					<?endif;?>
				</div>
			<?endif;?>
		</div>
		
		<?if ($arOptions['THUMB']['SHOW']):?>
		<div class="catalog-detail__gallery__thmb">
			<div class="catalog-detail__gallery__thmb-wrapper">
				<div class="catalog-detail__gallery-slider thmb owl-carousel owl-carousel--light js-detail-img-thmb<?=$arOptions['THUMB']['ITEM_CLASS'];?>" 
					 data-size="<?=$arOptions['TOTAL_COUNT'];?>" 
					 data-plugin-options='<?=$arOptions['THUMB']['CONFIG'];?>' 
					 style="max-width:<?=$arOptions['THUMB']['MAX_WIDTH'];?>;"
				>
					<?if ($arOptions['TOTAL_COUNT']):?>
						<?foreach($arGallery as $index => $arImage):?>
							<div id="thmb-photo-<?=$index;?>" class="catalog-detail__gallery__item catalog-detail__gallery__item--thmb">
								<img class="catalog-detail__gallery__picture" 
									 src="<?=$arImage['SRC']['THUMB'];?>" 
									 alt="<?=$arImage['ALT'];?>" 
									 title="<?=$arImage['ALT'];?>"
								>
							</div>
						<?endforeach;?>
					<?endif;?>
				</div>
				
				<?if ($arBlocks['POPUP_VIDEO']):?>
					<?=$arBlocks['POPUP_VIDEO']['HTML'];?>
				<?endif;?>
			</div>
		</div>
		<?endif;?>
	</div>

	<?if ($arOptions['DETAIL_BUTTON']):?>
		<div class="btn-wrapper">
			<a href="<?=$arOptions['DETAIL_BUTTON']['URL'];?>" 
				class="btn btn-default btn-sm btn-transparent-border btn-wide animate-load has-ripple js-replace-more" 
				title="<?=$arOptions['DETAIL_BUTTON']['TITLE'];?>"
			>
				<span><?=$arOptions['DETAIL_BUTTON']['TITLE'];?></span>
			</a>
		</div>
	<?endif;?>

	<?if ($arOptions['INNER_WRAPPER']):?>
		</div>
	<?endif;?>
</div>
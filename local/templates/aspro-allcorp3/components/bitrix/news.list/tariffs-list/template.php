<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

$arItems = $arResult['ITEMS'];
?>
<?if ($arItems):?>
<?
$bShowTitle = $arParams['TITLE'] && $arParams['SHOW_TITLE'];
$bShowTitleLink = $arParams['RIGHT_TITLE'] && $arParams['RIGHT_LINK'];
$bSlider = $arParams['SLIDER'] === true || $arParams['SLIDER'] === 'Y';
$bTopTabs = $arParams['TABS'] === 'TOP';
$bNarrow = $arParams['NARROW'];

$cntVisibleChars = intval($arParams['VISIBLE_PROP_COUNT']);
$cntVisibleChars = $cntVisibleChars >= 0 ? $cntVisibleChars : 4;

$bOrderViewBasket = $arParams['ORDER_VIEW'];
$basketURL = (strlen(trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE'])) ? trim($arTheme['ORDER_VIEW']['DEPENDENT_PARAMS']['URL_BASKET_SECTION']['VALUE']) : '');

if(
	$arParams['ROW_VIEW'] &&
	$arParams['IMAGES'] === 'BIG_PICTURES'
){
	$arParams['IMAGES'] = 'ROUND_PICTURES';
}

$bIcons = $arParams['IMAGES'] === 'ICONS';
$bShowImage = $bIcons || in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE']);
$bBigPictures = $arParams['IMAGES'] === 'BIG_PICTURES';
$bBGHover = !$arParams['ROW_VIEW'] && !$bBigPictures;

$blockClasses = ($arParams['ITEMS_OFFSET'] ? 'tariffs-list--items-offset' : 'tariffs-list--items-close');

$bMobileScrolledItems = (
	!isset($arParams['MOBILE_SCROLLED']) ||
	($arParams['MOBILE_SCROLLED'] === true || $arParams['MOBILE_SCROLLED'] === 'Y')
);

if($bSlider){
	$bDots1200 = $arParams['DOTS_1200'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_1200']) {
		$items1200 = intval($arParams['ITEM_1200']);
	}
	else{
		$items1200 = $arParams['ELEMENTS_ROW'] ? $arParams['ELEMENTS_ROW'] : 1;
	}

	$bDots768 = $arParams['DOTS_768'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_768']) {
		$items768 = intval($arParams['ITEM_768']);
	}
	else{
		$items768 =
			$arParams['ELEMENTS_ROW'] > 1 ? 2 : 1;
	}

	$bDots380 = $arParams['DOTS_380'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_380']) {
		$items380 = intval($arParams['ITEM_380']);
	}
	else{
		$items380 = 1;
	}

	$bDots0 = $arParams['DOTS_0'] === 'Y' ? 1 : 0;
	if($arParams['ITEM_0']) {
		$items0 = intval($arParams['ITEM_0']);
	}
	else{
		$items0 = 1;
	}

	$owlClasses = ' owl-carousel--light owl-carousel--items-width-360-adaptive owl-carousel--wide-adaptive owl-carousel--outer-dots owl-carousel--static-dots owl-carousel--dots-padding-top-20 owl-carousel--buttons-bordered owl-carousel--button-wide owl-carousel--items-'.$arParams['ELEMENTS_ROW'];
	if($arParams['NARROW']) {
		$owlClasses .= ' owl-carousel--button-offset-half';
	}
	else{
		$owlClasses .= ' owl-carousel--button-offset-none';
	}

	if($bShowImage && $arParams['IMAGES'] === 'BIG_PICTURES'){
		$owlClasses .= ' owl-carousel--button-offset-images';
	}

	if($arParams['ITEMS_OFFSET'] && !$arParams['NARROW']) {
		$owlClasses .= ' owl-carousel--padding-left-32';
		$owlClasses .= ' owl-carousel--padding-right-32';
	}
	if($arParams['SHOW_NEXT']) {
		$owlClasses .= ' owl-carousel--show-next';
		if($arParams['NARROW']) {
			$owlClasses .= ' owl-carousel--narrow';
		}
	}
	if(!$arParams['NARROW']) {
		$owlClasses .= ' owl-carousel--wide-view owl-carousel--buttons-size-48';
	}
	if($arParams['BORDER']) {
		$owlClasses .= ' owl-carousel--after-offset-1';
	}
	if(!$arParams['ITEMS_OFFSET']){
		$owlClasses .= ' owl-carousel--no-gap';
	}
	if ($arParams['ITEM_HOVER_SHADOW'] !== false){
		$owlClasses .= ' owl-carousel--with-shadow';
	}
	if(!$arParams['IS_AJAX']){
		$owlClasses .= ' appear-block';
	}
}
else{
	$gridClass = 'grid-list';
	if($arParams['MOBILE_SCROLLED']){
		$gridClass .= ' mobile-scrolled mobile-scrolled--items-2 mobile-offset';
	}
	if(!$arParams['ITEMS_OFFSET']){
		$gridClass .= ' grid-list--no-gap';
	}
	elseif ($arParams['GRID_GAP']) {
		$gridClass .= ' grid-list--gap-'.$arParams['GRID_GAP'];
	}
	if($arParams['NARROW']){
		$gridClass .= ' grid-list--items-'.$arParams['ELEMENTS_ROW'];
	}
	else{
		$gridClass .= ' grid-list--wide grid-list--items-'.$arParams['ELEMENTS_ROW'].'-wide';
	}
}

$itemWrapperClasses = ' grid-list__item';
if(!$arParams['ITEMS_OFFSET'] && $arParams['BORDER']){
	$itemWrapperClasses .= ' grid-list-border-outer';
}

$itemWrapperClasses .= ' color-theme-parent-all';

$itemClasses = 'height-100 flexbox bg-theme-parent-hover border-theme-parent-hover';
if($arParams['ROW_VIEW']){
	$itemClasses .= ' flexbox--direction-row';
}
if($arParams['COLUMN_REVERSE']){
	$itemClasses .= ' flexbox--direction-column-reverse';
}
if($arParams['BORDER']){
	$itemClasses .= ' bordered';
}
if($arParams['ROUNDED']){
	if(
		$arParams['ITEMS_OFFSET'] ||
		$arParams['ROW_VIEW']
	){
		$itemClasses .= ' rounded-4';
	}
}
if($arParams['ITEM_HOVER_SHADOW']){
	$itemClasses .= ' shadow-hovered shadow-no-border-hovered';
}
if($arParams['DARK_HOVER']){
	$itemClasses .= ' dark-block-hover';
}
if($arParams['ELEMENTS_ROW'] == 1){
	$itemClasses .= ' tariffs-list__item--wide';
}

$imageWrapperClasses = 'tariffs-list__item-image-wrapper--'.$arParams['IMAGES'];
if(!$bBigPictures){
	$imageWrapperClasses .= ' tariffs-list__item-image-wrapper--with-title';
}
if($bBGHover){
	$imageWrapperClasses .= ' tariffs-list__item-image-wrapper--bghover';
}

$imageClasses = $arParams['IMAGES'] === 'ROUND_PICTURES' ? 'rounded' : '';

$valY = TSolution::showIconSvg('tariff-yes fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/tariff_yes.svg');
$valN = TSolution::showIconSvg('tariff-no fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/tariff_no.svg');

$navPageNomer = $arResult['NAV_RESULT']->{'NavPageNomer'};
?>
<?if($bTopTabs):?>
	<?ob_start();?>
	<?if(
		$arResult['TABS'] &&
		(
			$arResult['TABS']['PROPS_TABS'] ||
			$arResult['TABS']['ITEMS_TABS']
		)
	):?>
		<div class="tab-nav-wrapper swipeignore">
			<div class="tab-nav font_14 <?=$arParams['TITLE_POSITION'] == 'LEFT' ? 'left-justify-content' : ''?>">
				<?foreach($arResult['TABS']['PROPS_TABS'] as $price_key => $title):?>
					<?$bCurrent = $arParams['DEFAULT_PRICE_KEY'] == $price_key;?>
					<div class="tab-nav__item  bg-opacity-theme-hover bg-theme-active bg-theme-hover-active color-theme-hover-no-active<?=($bCurrent ? ' active clicked' : '')?>" data-price_key="<?=$price_key?>"><?=$title?></div>
				<?endforeach;?>
				<?foreach($arResult['TABS']['ITEMS_TABS'] as $price_key => $title):?>
					<?$bCurrent = $arParams['DEFAULT_PRICE_KEY'] == $price_key;?>
					<div class="tab-nav__item  bg-opacity-theme-hover bg-theme-active bg-theme-hover-active color-theme-hover-no-active<?=($bCurrent ? ' active clicked' : '')?>" data-price_key="<?=$price_key?>"><?=$title?></div>
				<?endforeach;?>
			</div>
		</div>
	<?endif;?>
	<?$htmlTabs = trim(ob_get_clean());?>
<?endif;?>

<?if(!$arParams['IS_AJAX']):?>
	<div class="tariffs-list <?=$blockClasses?> <?=$templateName?>-template">
		<?=TSolution\Functions::showTitleBlock([
			'PATH' => 'tariffs-list',
			'PARAMS' => $arParams,
			'VISIBLE' => true,
			'CENTER_BLOCK' => $bTopTabs ? $htmlTabs : '',
			'LEFT_PART_CLASS' => 'flex-1',
			
		]);?>

		<?if($arParams['MAXWIDTH_WRAP']):?>
			<?if($arParams['NARROW']):?>
				<div class="maxwidth-theme">
			<?elseif($arParams['ITEMS_OFFSET'] && !$bSlider):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>
		<?endif;?>
<?endif;?>

		<?ob_start();?>
		<?if($navPageNomer < 2):?>
			<?if($bSlider):?>
				<div class="owl-carousel <?=$owlClasses?>" data-plugin-options='{"nav": true, "rewind": true, "dots": true, "dotsContainer": false, "loop": false, "autoplay": false, "marginMove": true, "margin": <?=($arParams['ITEMS_OFFSET'] ? ($arParams['GRID_GAP'] ? $arParams['GRID_GAP'] : "32") : ($arParams['BORDER'] ? "-1" : "0"))?>, "responsive": {"0": {"autoWidth": true, "lightDrag": true, "dots": <?=$bDots0?>, "items": <?=$items0?> <?=($arParams['ITEMS_OFFSET'] ? ', "margin": 24' : '')?>}, "380": {"autoWidth": true, "lightDrag": true, "dots": <?=$bDots380?>, "items": <?=$items380?> <?=($arParams['ITEMS_OFFSET'] ? ', "margin": 24' : '')?>}, "768": {"autoWidth": false, "lightDrag": false, "dots": <?=$bDots768?>, "items": <?=$items768?>}, "1200": {"autoWidth": false, "lightDrag": false, "dots": <?=$bDots1200?>, "items": <?=$items1200?>} }}'>
			<?else:?>
				<div class="<?=$gridClass?>">
			<?endif;?>
		<?endif;?>

				<?foreach($arItems as $i => $arItem):?>
					<?
					// edit/add/delete buttons for edit mode
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => Loc::getMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

					// use detail link?
					$bDetailLink = $arParams['USE_DETAIL'] === 'Y' && $arParams['SHOW_DETAIL_LINK'] != 'N' && (!strlen($arItem['DETAIL_TEXT']) ? ($arParams['HIDE_LINK_WHEN_NO_DETAIL'] !== 'Y' && $arParams['HIDE_LINK_WHEN_NO_DETAIL'] != 1) : true);

					// detail url
					$detailUrl = $arItem['DETAIL_PAGE_URL'];

					// preview text
					$previewText = $arItem['FIELDS']['PREVIEW_TEXT'];
					$htmlPreviewText = '';

					// preview image
					if($bShowImage){
						if($bIcons){
							$nImageID = $arItem['DISPLAY_PROPERTIES']['ICON']['VALUE'];
						}
						else{
							$nImageID = is_array($arItem['FIELDS']['PREVIEW_PICTURE']) ? $arItem['FIELDS']['PREVIEW_PICTURE']['ID'] : $arItem['FIELDS']['PREVIEW_PICTURE'];
						}

						$imageSrc = ($nImageID ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_content.svg');
					}

					// use order button?
					$bOrderButton = ($arItem['PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] === 'YES');
					$dataItem = ($bOrderViewBasket ? TSolution::getDataItem($arItem) : false);

					$bShowDetailButton = $bDetailLink && $arParams['NARROW'] && !$arParams['ROW_VIEW'] && $bTopTabs;
					$bShowPrice = $arItem['PRICES'];
					$bShowBottom = $bShowPrice || $bOrderButton;

					// stickers
					ob_start();
					TSolution\Functions::showStickers([
						'TYPE' => 'tariffs_block',
						'ITEM' => $arItem,
						'PARAMS' => $arParams,
						'WRAPPER' => 'sticker-wrap',
					]);
					$htmlStickers = trim(ob_get_clean());
					?>
					<div class="tariffs-list__wrapper <?=$itemWrapperClasses?>">
						<div class="tariffs-list__item js-popup-block <?=$itemClasses?> <?=($bDetailLink ? '' : 'tariffs-list__item--cursor-initial')?>" id="<?=$this->GetEditAreaId($arItem['ID'])?>">
							<?if(!$bBigPictures || ($bShowImage && $imageSrc)):?>
								<div class="tariffs-list__item-image-wrapper <?=$imageWrapperClasses?><?=($nImageID ? '' : ' tariffs-list__item-image-wrapper--noimage')?>">
									<?/*if($bBGHover):?>
										<?if($bDetailLink):?>
											<a class="tariffs-list__item-link" href="<?=$detailUrl?>">
										<?else:?>
											<span class="tariffs-list__item-link">
										<?endif;?>
									<?endif;*/?>

									<?if(!$bBigPictures):?>
										<div class="line-block line-block--align-normal<?=($bBGHover ? ' line-block--20 flexbox--justify-beetwen' : ($bIcons ? '' : '  line-block--40').' flexbox--direction-row-reverse flexbox--justify-end')?>">
									<?endif;?>

									<?if(!$bBigPictures):?>
										<div class="line-block__item">
											<?if($arParams['ROW_VIEW']):?>
												<?=$htmlStickers?>
											<?endif;?>

											<?if($arItem['SECTIONS'] && $arParams['SHOW_SECTION'] != 'N'):?>
												<div class="tariffs-list__item-section font_13 color_999"><?=implode(', ', $arItem['SECTIONS'])?></div>
											<?endif;?>

											<div class="tariffs-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
												<?if($bDetailLink):?>
													<a class="dark_link color-theme-target" href="<?=$detailUrl?>"><?=$arItem['NAME']?></a>
												<?else:?>
													<span class="color_333"><?=$arItem['NAME']?></span>
												<?endif;?>
											</div>
										</div>
									<?endif;?>

									<?if($bShowImage && $imageSrc):?>
										<?if(!$bBigPictures):?>
											<div class="line-block__item line-block__item--image">
										<?endif;?>

										<?if($bDetailLink):?>
											<a class="tariffs-list__item-link image-list__link detail-info__image" href="<?=$detailUrl?>" data-src="<?=$imageSrc?>">
										<?else:?>
											<span class="tariffs-list__item-link image-list__link detail-info__image" data-src="<?=$imageSrc?>">
										<?endif;?>
											<?if($bIcons && $nImageID):?>
												<?=TSolution::showIconSvg(' fill-theme tariffs-list__item-image-icon', $imageSrc);?>
											<?else:?>
												<span class="tariffs-list__item-image<?=(($bIcons && !$nImageID) ? ' rounded' : '')?> <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
											<?endif;?>
										<?if($bDetailLink):?>
											</a>
										<?else:?>
											</span>
										<?endif;?>

										<?if(!$bBigPictures):?>
											</div>
										<?endif;?>
									<?endif;?>

									<?if(!$bBigPictures):?>
										</div>
									<?endif;?>

									<?/*if($bBGHover):?>
										<?if($bDetailLink):?>
											</a>
										<?else:?>
											</span>
										<?endif;?>
									<?endif;*/?>
								</div>
							<?endif;?>

							<div
								class="tariffs-list__item-text-wrapper flexbox
								<?=($bShowBottom ? ' tariffs-list__item-text-wrapper--has-bottom-part' : '')?>"
								data-id="<?=$arItem['ID']?>"
								<?=($bOrderViewBasket ? ' data-item="'.$dataItem.'"' : '')?>
							>
								<div class="tariffs-list__item-text-top-part
									<?=($arParams['ROW_VIEW'] ? '' : 'no-shrinked')?>
									<?=(!$arParams['ROW_VIEW'] && $htmlStickers ? ' tariffs-list__item-text-top-part--has-stickers' : '')?>
									<?=(!$arParams['NARROW'] && !($bShowImage && $imageSrc)) ? ' flex-1' : ''?>">
									<?if(!$arParams['ROW_VIEW']):?>
										<?=$htmlStickers?>
									<?endif;?>

									<?if($bBigPictures):?>
										<?if($arItem['SECTIONS'] && $arParams['SHOW_SECTION'] != 'N'):?>
											<div class="tariffs-list__item-section font_13 color_999"><?=implode(', ', $arItem['SECTIONS'])?></div>
										<?endif;?>

										<div class="tariffs-list__item-title switcher-title font_<?=$arParams['NAME_SIZE']?>">
											<?if($bDetailLink):?>
												<a class="dark_link color-theme-target" href="<?=$detailUrl?>"><?=$arItem['NAME']?></a>
											<?else:?>
												<span class="color_333"><?=$arItem['NAME']?></span>
											<?endif;?>
										</div>
									<?endif;?>

									<?if(
										in_array('PREVIEW_TEXT', $arParams['FIELD_CODE']) &&
										$arParams['SHOW_PREVIEW'] &&
										strlen($previewText)
									):?>
										<?ob_start()?>
											<div class="tariffs-list__item-preview-wrapper">
												<div class="tariffs-list__item-preview font_15 color_666">
													<?=$previewText?>
												</div>
											</div>
										<?$htmlPreviewText = ob_get_clean()?>
										<?=$htmlPreviewText?>
									<?endif;?>

									<?if(
										$arItem['FORMAT_PROPS'] ||
										$arItem['MIDDLE_PROPS']
									):?>
										<?$j = 0;?>
										<?if(array_key_exists('FORMAT_PROPS', $arItem) && $arItem['FORMAT_PROPS']):?>
											<?ob_start();?>
												<?foreach($arItem['FORMAT_PROPS'] as $PCODE => $arProperty):?>
													<?$bCollapsed = ++$j > $cntVisibleChars;?>
													<div class="tariffs-list__item-properties-item-wraper<?=($bCollapsed ? ' collapsed' : '')?>"<?=($bCollapsed ? ' style="display:none"' : '')?>>
														<div class="tariffs-list__item-properties-item color_333" data-code="<?=strtolower($PCODE)?>">
															<?if($arProperty['VALUE_XML_ID'] == 'Y'):?>
																<?$val = $valY;?>
															<?elseif($arProperty['VALUE_XML_ID'] == 'N'):?>
																<?$val = $valN;?>
															<?else:?>
																<?if(is_array($arProperty['DISPLAY_VALUE'])):?>
																	<?$val = implode('&nbsp;/&nbsp;', $arProperty['DISPLAY_VALUE']);?>
																<?else:?>
																	<?$val = $arProperty['DISPLAY_VALUE'];?>
																<?endif;?>
															<?endif;?>
															<span class="tariffs-list__item-properties-item-name"><?=$arProperty['NAME']?><span class="tariffs-list__item-properties-item-dash">&nbsp;&nbsp;&mdash;&nbsp;&nbsp;</span></span><span class="tariffs-list__item-properties-item-value font_weight--600"><?=$val?></span>
														</div>
													</div>
												<?endforeach;?>
											<?$htmlProperties = trim(ob_get_clean());?>

											<?if($htmlProperties):?>
												<div class="tariffs-list__item-properties font_14<?=($arParams['ROW_VIEW'] ? ' tariffs-list__item-properties--table' : '')?><?=($bBigPictures ? ' tariffs-list__item-properties--top-border' : '')?>"><?=$htmlProperties?></div>
											<?endif;?>
										<?endif;?>

										<?
										$bMiddlePropertiesCollapsed =
										$j >= $cntVisibleChars &&
										array_key_exists('MIDDLE_PROPS', $arItem) &&
										$arItem['MIDDLE_PROPS'];
										if(
											array_key_exists('MIDDLE_PROPS', $arItem) &&
											$arItem['MIDDLE_PROPS']
										):?>
											<?ob_start();?>
											<?foreach($arItem['MIDDLE_PROPS'] as $PCODE => $arProperty):?>
												<?foreach((array)$arProperty['DISPLAY_VALUE'] as $val):?>
													<?$bCollapsed = $bMiddlePropertiesCollapsed ? false : (++$j > $cntVisibleChars);?>
													<div class="tariffs-list__item-properties-item-wraper<?=($bCollapsed ? ' collapsed' : '')?>"<?=($bCollapsed ? ' style="display:none"' : '')?>>
														<div class="tariffs-list__item-properties-item color_333">
															<span class="tariffs-list__item-properties-item-value"><?=$val?></span>
														</div>
													</div>
												<?endforeach;?>
											<?endforeach;?>
											<?$htmlMiddleProperties = trim(ob_get_clean());?>

											<?if($htmlMiddleProperties):?>
												<div class="tariffs-list__item-properties tariffs-list__item-properties--middle font_14<?=($bBigPictures ? ' tariffs-list__item-properties--top-border' : '')?><?=($bMiddlePropertiesCollapsed ? ' collapsed' : '')?>"<?=($bMiddlePropertiesCollapsed ? ' style="display:none"' : '')?>><?=$htmlMiddleProperties?></div>
											<?endif;?>
										<?endif;?>

										<?if($j > $cntVisibleChars || ($bMiddlePropertiesCollapsed && $htmlMiddleProperties)):?>
											<div class="tariffs-list__item-properties-item-more font_13 dotted" data-toggletext="<?=Loc::getMessage('HIDE_COLLAPSED_PROPERTIES')?>"><?=Loc::getMessage('SHOW_COLLAPSED_PROPERTIES')?></div>
										<?endif;?>
									<?endif;?>
								</div>

								<?if($bShowBottom):?>
									<div class="tariffs-list__item-text-bottom-part<?=($bShowPrice ? ' tariffs-list__item-text-bottom-part--has-price' : '')?>">
										<?if($bShowPrice):?>
											<?if(count($arItem['PRICES']) > 1):?>
												<div class="tariffs-list__tabs color_333">
													<?foreach($arItem['PRICES'] as $arPrice):?>
														<div
															class="tariffs-list__tabs__item<?=($arPrice['DEFAULT'] ? ' tariffs-list__tabs__item--default current' : '')?>"
															data-name="<?=TSolution::formatJsName($arItem['NAME'].' ('.$arPrice['TITLE'].')')?>"
															data-filter_price="<?=$arPrice['FILTER_PRICE']?>"
															data-price="<?=TSolution::formatJsName($arPrice['PRICE'])?>"
															data-oldprice="<?=TSolution::formatJsName($arPrice['OLDPRICE'])?>"
															data-economy="<?=TSolution::formatJsName($arPrice['ECONOMY'])?>"
															<?if(isset($arPrice['PRICE_ONE'])):?>
																data-price_one="<?=TSolution::formatJsName($arPrice['PRICE_ONE'])?>"
															<?endif;?>
															<?if(isset($arPrice['OLDPRICE_ONE'])):?>
																data-oldprice_one="<?=TSolution::formatJsName($arPrice['OLDPRICE_ONE'])?>"
															<?endif;?>
														><?=$arPrice['TITLE']?></div>
													<?endforeach;?>
												</div>
											<?endif;?>
											<div class="tariffs-list__tabs-content">
												<?foreach($arItem['PRICES'] as $arPrice):?>
													<div class="tariffs-list__tabs-content__item<?=($arPrice['DEFAULT'] ? '' : ' hidden')?>">
														<div class="tariffs-list__item-price">
															<div class="price color_333">
																<?if($arPrice['CNT_PERIODS'] == 1):?>
																	<?if($arPrice['PRICE'] !== false):?>
																		<div class="price__new">
																			<div class="price__new-val font_17"><?=$arPrice['PRICE']?></div>
																		</div>
																	<?endif;?>
																<?else:?>
																	<?if(
																		(
																			isset($arPrice['OLDPRICE_ONE']) &&
																			$arPrice['OLDPRICE_ONE'] !== false
																		) ||
																		(
																			isset($arPrice['PRICE_ONE']) &&
																			$arPrice['PRICE_ONE'] !== false
																		)
																	):?>
																		<?if($arPrice['OLDPRICE_ONE'] !== false):?>
																			<div class="price__old">
																				<div class="price__old-val font_13 color_999"><?=$arPrice['OLDPRICE_ONE']?></div>
																			</div>
																		<?endif;?>
																		<?if($arPrice['PRICE_ONE'] !== false):?>
																			<div class="price__new">
																				<div class="price__new-val font_17"><?=$arPrice['PRICE_ONE']?></div>
																			</div>
																		<?endif;?>
																		<div class="price--inline">
																			<?if($arPrice['PRICE'] !== false):?>
																				<div class="price__new">
																					<div class="price__new-val font_13 color_999 font_weight--600"><?=$arPrice['PRICE']?></div>
																				</div>
																			<?endif;?>
																			<?if($arPrice['ECONOMY'] !== false):?>
																				<div class="price__economy rounded-3">
																					<div class="price__economy-val font_11"><?=$arPrice['ECONOMY']?></div>
																				</div>
																			<?endif;?>
																		</div>
																	<?else:?>
																		<?if($arPrice['PRICE'] !== false):?>
																			<div class="price__new">
																				<div class="price__new-val font_17"><?=$arPrice['PRICE']?></div>
																			</div>
																		<?endif;?>
																		<?if($arPrice['OLDPRICE'] !== false):?>
																			<div class="price--inline">
																				<div class="price__old">
																					<div class="price__old-val font_13 color_999"><?=$arPrice['OLDPRICE']?></div>
																				</div>
																				<?if($arPrice['ECONOMY'] !== false):?>
																					<div class="price__economy rounded-3">
																						<div class="price__economy-val font_11"><?=$arPrice['ECONOMY']?></div>
																					</div>
																				<?endif;?>
																			</div>
																		<?endif;?>
																	<?endif;?>
																<?endif;?>
															</div>
														</div>
													</div>
												<?endforeach;?>
											</div>
										<?endif;?>
										<?if($bOrderButton):?>
											<div class="tariffs-list__item_buttons<?=($bShowDetailButton ? ' line-block--8-vertical' : ($arParams['ROW_VIEW'] ? ' line-block' : ''))?>">
												<div class="line-block__item">
													<?=TSolution\Functions::showBasketButton([
														'ITEM' => $arItem['DEFAULT_PRICE'] ? array_merge(
															$arItem,
															array(
																'NAME' => $arItem['NAME'].' ('.$arItem['DEFAULT_PRICE']['TITLE'].')',
															)
														) : $arItem,
														'PARAMS' => $arParams,
														'BASKET_URL' => $basketURL,
														'BASKET' => $bOrderViewBasket,
														'ORDER_BTN' => $bOrderButton,
														'BTN_CLASS' => 'bg-theme-target border-theme-target btn-transparent-border'.($arParams['ROW_VIEW'] ? '' : ' btn-wide'),
														'BTN_IN_CART_CLASS' => ($arParams['ROW_VIEW'] ? '' : ' btn-wide'),
														'SHOW_COUNTER' => false,
													]);?>
												</div>
												<?/*if($bShowDetailButton):?>
													<div class="line-block__item">
														<div class="btn btn-wide btn-transparent"><?=Loc::getMessage('SHOW_MORE')?></div>
													</div>
												<?endif;*/?>
											</div>
										<?endif;?>
									</div>
								<?endif;?>
							</div>
						</div>
					</div>
				<?endforeach;?>

				<?if(!$bSlider):?>
					<?if($bMobileScrolledItems):?>
						<?if($arParams['IS_AJAX'] && $navPageNomer > 1):?>
							<div class="wrap_nav bottom_nav_wrapper">
						<?endif;?>
							<?$bHasNav = (strpos($arResult["NAV_STRING"], 'more_text_ajax') !== false);?>
							<div class="bottom_nav mobile_slider <?=($bHasNav ? '' : ' hidden-nav');?>" data-parent=".tariffs-list" data-append=".grid-list" <?=(($arParams['IS_AJAX'] && $navPageNomer > 1) ? "style='display: none; '" : "");?>>
								<?if($bHasNav):?>
									<?=$arResult["NAV_STRING"]?>
								<?endif;?>
							</div>

						<?if($arParams['IS_AJAX'] && $navPageNomer > 1):?>
							</div>
						<?endif;?>
					<?endif;?>
				<?endif;?>

		<?if($navPageNomer < 2):?>
			</div>
		<?endif;?>

		<?// bottom pagination?>
		<?if($arParams['IS_AJAX'] && $navPageNomer > 1):?>
			<div class="wrap_nav bottom_nav_wrapper">
		<?endif;?>

		<div class="bottom_nav_wrapper nav-compact <?=($bSlider ? 'hidden' : '')?>">
			<div class="bottom_nav <?=($bMobileScrolledItems ? 'hide-600' : '');?>" <?=(($arParams['IS_AJAX'] && $navPageNomer > 1) ? "style='display: none; '" : "");?> data-parent="<?=($bTopTabs ? '.tab-content-block' : '.tariffs-list')?>" data-append=".grid-list">
				<?if($arParams['DISPLAY_BOTTOM_PAGER']):?>
					<?=$arResult['NAV_STRING']?>
				<?endif;?>
			</div>
		</div>

		<?if($arParams['IS_AJAX']):?>
			<script>
			$(document).ready(function(){
				setBasketItemsClasses();
				<?if($bSlider):?>InitOwlSlider();<?endif;?>
			});
			</script>
		<?endif;?>

		<?if($arParams['IS_AJAX'] && $navPageNomer > 1):?>
			</div>
		<?endif;?>
		<?$htmlItems = trim(ob_get_clean());?>

		<?if($arParams['IS_AJAX']):?>
			<?=$htmlItems?>
		<?else:?>
			<?if($bTopTabs):?>
				<div class="js-tabs-ajax">
					<?if(
						$arResult['TABS'] &&
						(
							$arResult['TABS']['PROPS_TABS'] ||
							$arResult['TABS']['ITEMS_TABS']
						)
					):?>
						<?foreach($arResult['TABS']['PROPS_TABS'] as $price_key => $title):?>
							<?$bCurrent = $arParams['DEFAULT_PRICE_KEY'] == $price_key;?>
							<div class="tab-content-block <?=($bCurrent ? ' active' : ' loading-state')?>" data-price_key="<?=$price_key?>">
								<?if($bCurrent):?>
									<?=$htmlItems?>
								<?endif;?>
							</div>
						<?endforeach;?>
						<?foreach($arResult['TABS']['ITEMS_TABS'] as $price_key => $title):?>
							<?$bCurrent = $arParams['DEFAULT_PRICE_KEY'] == $price_key;?>
							<div class="tab-content-block <?=($bCurrent ? ' active' : ' loading-state')?>" data-price_key="<?=$price_key?>">
								<?if($bCurrent):?>
									<?=$htmlItems?>
								<?endif;?>
							</div>
						<?endforeach;?>
					<?endif;?>
				</div>
			<?else:?>
				<?=$htmlItems?>
			<?endif;?>
		<?endif;?>

<?if(!$arParams['IS_AJAX']):?>
		<?if($arParams['MAXWIDTH_WRAP']):?>
			<?if($arParams['NARROW']):?>
				</div>
			<?elseif($arParams['ITEMS_OFFSET'] && !$bSlider):?>
				</div>
			<?endif;?>
		<?endif;?>

	</div> <?// .tariffs-list?>
<?endif;?>
<?endif;?>
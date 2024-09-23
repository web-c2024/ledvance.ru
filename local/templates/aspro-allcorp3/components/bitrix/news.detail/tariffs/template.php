<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

$this->setFrameMode(true);

$bOrderViewBasket = $arParams['ORDER_VIEW'];
$dataItem = $bOrderViewBasket ? TSolution::getDataItem($arResult) : false;
$bOrderButton = $arResult['PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES';
$bAskButton = $arResult['PROPERTIES']['FORM_QUESTION']['VALUE_XML_ID'] == 'YES';
$bShowPrice = $arResult['PRICES'];
$bRightImg = $arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] === 'RIGHT';
$bTopImg = (strpos($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'], 'TOP') !== false);
$bTopWide = $arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] === 'TOP';
$bWide = $arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] === 'WIDE';
$bTopNarrow = $arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] === 'TOP_CONTENT';

// preview image
$bIcon = false;
$nImageID = is_array($arResult['FIELDS']['PREVIEW_PICTURE']) ? $arResult['FIELDS']['PREVIEW_PICTURE']['ID'] : $arResult['FIELDS']['PREVIEW_PICTURE'];
if(!$nImageID){
	if($nImageID = $arResult['DISPLAY_PROPERTIES']['ICON']['VALUE']){
		$bIcon = true;
	}
}
$imageSrc = ($nImageID ? CFile::getPath($nImageID) : SITE_TEMPLATE_PATH.'/images/svg/noimage_content.svg');
$bShowImage = $nImageID && ($arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] === 'LEFT' || $arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] === 'RIGHT');

$valY = TSolution::showIconSvg('tariff-yes fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/tariff_yes.svg');
$valN = TSolution::showIconSvg('tariff-no fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/tariff_no.svg');

/*set array props for component_epilog*/
$templateData = array(
	'ORDER' => $bOrderViewBasket,
	'ORDER_BTN' => ($bOrderButton || $bAskButton),
	'PREVIEW_PICTURE' => $arResult['PREVIEW_PICTURE'],
	'FAQ' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_FAQ')),
	'REVIEWS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_REVIEWS')),
	'PARTNERS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_PARTNERS')),
	'SALE' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_SALE')),
	'NEWS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_NEWS')),
	'STAFF' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_STAFF')),
	'ARTICLES' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_ARTICLES')),
	'PROJECTS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_PROJECTS')),
	'SERVICES' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_SERVICES')),
	'GOODS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_GOODS', 'LINK_GOODS_FILTER'), array('LINK_TARIF')),
	'PREVIEW_TEXT' => strlen($arResult['FIELDS']['PREVIEW_TEXT']) && (!isset($arResult['PROPERTIES']['BNR_TOP']) || $arResult['PROPERTIES']['BNR_TOP']['VALUE_XML_ID'] !== 'YES'),
);
?>
<?if($arResult['CATEGORY_ITEM']):?>
	<meta itemprop="category" content="<?=$arResult['CATEGORY_ITEM'];?>" />
<?endif;?>
<?if($arResult['DETAIL_PICTURE']):?>
	<meta itemprop="image" content="<?=$arResult['DETAIL_PICTURE']['SRC'];?>" />
<?endif;?>
<meta itemprop="name" content="<?=$arResult['NAME'];?>" />
<link itemprop="url" href="<?=$arResult['DETAIL_PAGE_URL'];?>" />

<?ob_start();?>
	<div class="btn btn-default btn-wide btn-lg btn-transparent-border animate-load" data-event="jqm" data-param-id="<?=TSolution::getFormID("question");?>" data-autoload-need_product="<?=TSolution::formatJsName($arResult['NAME'])?>" data-name="question">
		<span><?=(strlen($arParams['S_ASK_QUESTION']) ? $arParams['S_ASK_QUESTION'] : Loc::getMessage('S_ASK_QUESTION'))?></span>
	</div>
<?$askButtonHtml = ob_get_clean();?>

<?ob_start();?>
	<div class="btn btn-default btn-wide btn-lg animate-load" 
	data-event="jqm" 
	data-param-id="<?=TSolution::getFormID($arParams['FORM_ID_ORDER_SERVISE']);?>" data-autoload-need_product="<?=TSolution::formatJsName($arResult['NAME'])?>" 
	data-autoload-service="<?=\TSolution::formatJsName($arResult["NAME"]);?>" 
	data-autoload-project="<?=\TSolution::formatJsName($arResult["NAME"]);?>" 
	data-autoload-news="<?=\TSolution::formatJsName($arResult["NAME"]);?>" 
	data-autoload-sale="<?=\TSolution::formatJsName($arResult["NAME"]);?>" 
	data-name="order_project">
		<span><?=(strlen($arParams['S_ORDER_SERVISE']) ? $arParams['S_ORDER_SERVISE'] : Loc::getMessage('S_ORDER_PROJECT'))?></span>
	</div>
<?$orderButtonHtml = ob_get_clean();?>

<?// detail description?>
<?$templateData['DETAIL_TEXT'] = boolval(strlen($arResult['DETAIL_TEXT']));?>
<?if($templateData['DETAIL_TEXT']):?>
	<?$this->SetViewTarget('PRODUCT_DETAIL_TEXT_INFO');?>
		<div class="content" itemprop="description">
			<?if ($templateData['DETAIL_TEXT']):?>
				<?=$arResult['DETAIL_TEXT'];?>
			<?endif;?>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>

<?// detail info?>
<?ob_start();?>
<div class="detail-info-wrapper<?=($bShowImage ? ' detail-info-wrapper--has-image' : '')?><?=($bTopWide ? ' bordered rounded-4' : '')?><?=($bWide && $arResult['DETAIL_PICTURE']['SRC'] ? ' detail-info-wrapper--m41' : ((($bTopNarrow || $bTopWide) && $arResult['DETAIL_PICTURE']['SRC']) ? ' detail-info-wrapper--m48' : ''))?>">
	<?if($bTopNarrow || $bTopWide):?>
		<div class="maxwidth-theme">
	<?endif;?>

		<div class="detail-info js-popup-block<?=($bTopWide ? '' : ' bordered rounded-4')?>">			
			<div class="detail-info__image-wrapper rounded<?=($bShowImage ? '' : ' hidden')?><?=($bRightImg ? ' detail-info__image-wrapper--right' : '')?>">
				<div class="detail-info__image" data-src="<?=$imageSrc?>">
					<?if($bIcon):?>
						<?=TSolution::showIconSvg(' fill-theme tariffs-list__item-image-icon', $imageSrc);?>
					<?else:?>
						<span class="tariffs-list__item-image<?=(($bIcons && !$nImageID) ? ' rounded' : '')?> <?=$imageClasses?>" style="background-image: url(<?=$imageSrc?>);"></span>
					<?endif;?>
				</div>
			</div>

			<div class="detail-info__text-wrapper flexbox" data-id="<?=$arResult['ID']?>"<?=($bOrderViewBasket ? ' data-item="'.$dataItem.'"' : '')?>>
				<div class="detail-info__text-top-part">
					<?TSolution\Functions::showStickers([
						'TYPE' => '',
						'ITEM' => $arResult,
						'PARAMS' => $arParams,
					]);?>

					<?if($templateData['PREVIEW_TEXT']):?>
						<div class="introtext"<?=($templateData['DETAIL_TEXT'] ? '' : ' itemprop="description"')?>>
							<?if($arResult['PREVIEW_TEXT_TYPE'] == 'text'):?>
								<p><?=$arResult['FIELDS']['PREVIEW_TEXT'];?></p>
							<?else:?>
								<?=$arResult['FIELDS']['PREVIEW_TEXT'];?>
							<?endif;?>
						</div>
					<?endif;?>

					<?if(
						$arResult['CHARACTERISTICS'] ||
						$arResult['MIDDLE_PROPS']
					):?>
						<div class="props_block props_block--table">
							<table class="props_block__wrapper ">
								<tbody class="js-offers-prop">
									<?
									$bShowMoreChar = false;
									$j = 0;
									?>
									<?foreach($arResult['CHARACTERISTICS'] as $arProp):?>
										<?if($j < $arParams['VISIBLE_PROP_COUNT']):?>
											<tr class="char">
												<td class="char_name font_15 color_666">
													<div class="props_item js-prop-title <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
														<span><?=$arProp["NAME"]?></span>
														<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint hint--down"><span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
													</div>
												</td>
												<td class="char_value font_15 color_333 js-prop-value">
													<?if($arProp['VALUE_XML_ID'] == 'Y'):?>
														<?$val = $valY;?>
													<?elseif($arProp['VALUE_XML_ID'] == 'N'):?>
														<?$val = $valN;?>
													<?else:?>
														<?if(is_array($arProp['DISPLAY_VALUE'])):?>
															<?$val = implode('&nbsp;/&nbsp;', $arProp['DISPLAY_VALUE']);?>
														<?else:?>
															<?$val = $arProp['DISPLAY_VALUE'];?>
														<?endif;?>
													<?endif;?>
													<span>
														<?=$val;?>
													</span>
												</td>
											</tr>
											<?$j++;?>
										<?else:?>
											<?$bShowMoreChar = true;?>
										<?endif;?>
									<?endforeach;?>

									<?if($bShowMoreChar):?>
										<tr><td colspan="2">
										<div class="more-char-link">
											<span class="choise dotted colored pointer" data-block="char"><?=Loc::getMessage('MORE_CHAR_BOTTOM');?></span>
										</div>
										</td></tr>
									<?else:?>
										<?$arResult['CHARACTERISTICS'] = [];?>
									<?endif;?>

									<?foreach($arResult['MIDDLE_PROPS'] as $PCODE => $arProperty):?>
										<?foreach((array)$arProperty['DISPLAY_VALUE'] as $val):?>
											<tr class="char char--middle">
												<td class="char_name font_15 color_666" colspan="2">
													<div class="props_item js-prop-title">
														<span><?=$val?></span>
													</div>
												</td>
											</tr>
										<?endforeach;?>
									<?endforeach;?>
								</tbody>
							</table>
						</div>
					<?endif;?>
				</div>

				<div class="detail-info__text-bottom-part<?=($bShowPrice ? ' detail-info__text-bottom-part--has-price' : '')?>">
				<?if($bShowPrice):?>
					<?if(is_array($arResult['PRICES']) && count($arResult['PRICES']) > 1):?>
						<div class="detail-info__tabs color_333">
							<?foreach($arResult['PRICES'] as $arPrice):?>
								<div
									class="detail-info__tabs__item<?=($arPrice['DEFAULT'] ? ' detail-info__tabs__item--default current' : '')?>"
									data-name="<?=TSolution::formatJsName($arResult['NAME'].' ('.$arPrice['TITLE'].')')?>"
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
					<div class="detail-info__tabs-content">
						<?foreach($arResult['PRICES'] as $arPrice):?>
							<div class="detail-info__tabs-content__item<?=($arPrice['DEFAULT'] ? '' : ' hidden')?>">
								<div class="detail-info__price">
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
					<div class="detail-info__buttons">
						<div class="line-block__item">
							<?=TSolution\Functions::showBasketButton([
								'ITEM' => $arResult['DEFAULT_PRICE'] ? array_merge(
									$arResult,
									array(
										'NAME' => $arResult['NAME'].' ('.$arResult['DEFAULT_PRICE']['TITLE'].')',
									)
								) : $arResult,
								'PARAMS' => $arParams,
								'BASKET_URL' => $basketURL,
								'BASKET' => $bOrderViewBasket,
								'ORDER_BTN' => $bOrderButton,
								'BTN_CLASS' => 'btn-lg btn-wide',
								'BTN_IN_CART_CLASS' => 'btn-lg btn-wide',
								'BTN_CLASS_MORE' => 'bg-theme-target border-theme-target btn-wide',
								'BTN_CALLBACK_CLASS' => 'btn-transparent-border btn-wide btn-lg',
								'BTN_OCB_CLASS' => 'btn-transparent-border btn-wide btn-lg',
								'SHOW_COUNTER' => false,
								'QUESTION_BTN' => $bAskButton,
							]);?>
						</div>
					</div>
				<?endif;?>
				</div>
			</div>
		</div>

	<?if($bTopNarrow || $bTopWide):?>
		</div>
	<?endif;?>
</div>
<?$detailInfoHtml = ob_get_clean();?>

<?// top banner?>
<?$templateData['SECTION_BNR_CONTENT'] = isset($arResult['PROPERTIES']['BNR_TOP']) && $arResult['PROPERTIES']['BNR_TOP']['VALUE_XML_ID'] == 'YES';?>
<?if($templateData['SECTION_BNR_CONTENT']):?>
	<?
	$templateData['SECTION_BNR_UNDER_HEADER'] = $arResult['PROPERTIES']['BNR_TOP_UNDER_HEADER']['VALUE_XML_ID'];
	$templateData['SECTION_BNR_COLOR'] = $arResult['PROPERTIES']['BNR_TOP_COLOR']['VALUE_XML_ID'];
	$atrTitle = $arResult['PROPERTIES']['BNR_TOP_BG']['DESCRIPTION'] ?: $arResult['PROPERTIES']['BNR_TOP_BG']['TITLE'] ?: $arResult['NAME'];
	$atrAlt = $arResult['PROPERTIES']['BNR_TOP_BG']['DESCRIPTION'] ?: $arResult['PROPERTIES']['BNR_TOP_BG']['ALT'] ?: $arResult['NAME'];
	?>
	<?$this->SetViewTarget('section_bnr_content');?>
		<?TSolution\Functions::showBlockHtml(array(
			'FILE' => '/images/detail_banner.php',
			'PARAMS' => array(
				'TITLE' => $arResult['NAME'],
				'COLOR' => $templateData['SECTION_BNR_COLOR'],
				'TEXT' => array(
					'TOP' => $arResult['SECTION'] ? reset($arResult['SECTION']['PATH'])['NAME'] : '',
					'PREVIEW' => array(
						'TYPE' => $arResult['FIELDS']['PREVIEW_TEXT_TYPE'],
						'VALUE' => strlen($arResult['PROPERTIES']['ANONS']['VALUE']) ? $arResult['PROPERTIES']['ANONS']['VALUE'] : $arResult['FIELDS']['PREVIEW_TEXT'],
					),
				),
				'PICTURES' => array(
					'BG' => CFile::GetFileArray($arResult['PROPERTIES']['BNR_TOP_BG']['VALUE']),
					'IMG' => CFile::GetFileArray($arResult['PROPERTIES']['BNR_TOP_IMG']['VALUE']),
				),
				'BUTTONS' => array(
					array(
						'TITLE' => $arResult['PROPERTIES']['BUTTON_TEXT']['VALUE'] ?? '',
						'CLASS' => 'btn btn-default choise',
						'ATTR' => array(
							'data-block=".right_block .detail"',
						),
					),
				),
				'ATTR' => array(
					'ALT' => $atrAlt,
					'TITLE' => $atrTitle,
				),
				'TOP_IMG' => false
			),
		));?>
	<?$this->EndViewTarget();?>
<?elseif(
	$arResult['FIELDS']['DETAIL_PICTURE'] &&
	!$bShowImage
):?>
	<?
	// single detail image
	$templateData['BANNER_TOP_ON_HEAD'] = isset($arResult['PROPERTIES']['PHOTOPOS']) && $arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'] == 'TOP_ON_HEAD';

	$atrTitle = (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['TITLE']) ? $arResult['DETAIL_PICTURE']['TITLE'] : $arResult['NAME']));
	$atrAlt = (strlen($arResult['DETAIL_PICTURE']['DESCRIPTION']) ? $arResult['DETAIL_PICTURE']['DESCRIPTION'] : (strlen($arResult['DETAIL_PICTURE']['ALT']) ? $arResult['DETAIL_PICTURE']['ALT'] : $arResult['NAME']));
	?>
	<?if ($bTopImg):?>
		<?if ($templateData['BANNER_TOP_ON_HEAD']):?>
			<?$this->SetViewTarget('side-over-title');?>
		<?else:?>
			<?$this->SetViewTarget('top_section_filter_content');?>
		<?endif;?>
	<?endif;?>

	<?TSolution\Functions::showBlockHtml([
		'FILE' => '/images/detail_single.php',
		'PARAMS' => [
			'TYPE' => $arResult['PROPERTIES']['PHOTOPOS']['VALUE_XML_ID'],
			'URL' => $arResult['DETAIL_PICTURE']['SRC'],
			'ALT' => $atrAlt,
			'TITLE' => $atrTitle,
			'TOP_IMG' => $bTopImg
		],
	])?>

	<?if($bTopWide || $bTopNarrow):?>
		<?=$detailInfoHtml?>
	<?endif;?>

	<?if ($bTopImg):?>
		<?$this->EndViewTarget();?>
	<?endif;?>
	
<?endif;?>

<?// form question?>
<?if($bAskButton):?>
	<?$this->SetViewTarget('under_sidebar_content');?>
		<div class="ask-block bordered rounded-4">
			<div class="ask-block__container">
				<div class="ask-block__icon">
					<?=TSolution::showIconSvg('ask colored', SITE_TEMPLATE_PATH.'/images/svg/Question_lg.svg');?>
				</div>
				<div class="ask-block__text text-block color_666 font_14">
					<?$APPLICATION->IncludeComponent(
						'bitrix:main.include',
						'',
						array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "ask",
							"EDIT_TEMPLATE" => ""
						)
					);?>
				</div>
				<div class="ask-block__button">
					<?=str_replace('btn-wide btn-lg', '', $askButtonHtml);?>
				</div>
			</div>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>

<?// props content?>
<?$templateData['CHARACTERISTICS'] = boolval($arResult['CHARACTERISTICS']);?>
<?if($arResult['CHARACTERISTICS']):?>
	<?$this->SetViewTarget('PRODUCT_PROPS_INFO');?>
		<?$strGrupperType = $arParams["GRUPPER_PROPS"];?>
		<?if($strGrupperType == "GRUPPER"):?>
			<?if($arResult['CHARACTERISTICS']):?>
				<div class="props_block bordered rounded-4">
					<div class="props_block__wrapper">
						<?$APPLICATION->IncludeComponent(
							"redsign:grupper.list",
							"",
							Array(
								"CACHE_TIME" => "3600000",
								"CACHE_TYPE" => "A",
								"COMPOSITE_FRAME_MODE" => "A",
								"COMPOSITE_FRAME_TYPE" => "AUTO",
								"DISPLAY_PROPERTIES" => $arResult["CHARACTERISTICS"]
							),
							$component, array('HIDE_ICONS'=>'Y')
						);?>
					</div>
				</div>
			<?endif;?>
		<?elseif($strGrupperType == "WEBDEBUG"):?>
			<?if($arResult['CHARACTERISTICS']):?>
				<div class="props_block bordered rounded-4">
					<div class="props_block__wrapper">
						<?$APPLICATION->IncludeComponent(
							"webdebug:propsorter",
							"linear",
							array(
								"IBLOCK_TYPE" => $arResult['IBLOCK_TYPE'],
								"IBLOCK_ID" => $arResult['IBLOCK_ID'],
								"PROPERTIES" => $arResult['CHARACTERISTICS'],
								"EXCLUDE_PROPERTIES" => array(),
								"WARNING_IF_EMPTY" => "N",
								"WARNING_IF_EMPTY_TEXT" => "",
								"NOGROUP_SHOW" => "Y",
								"NOGROUP_NAME" => "",
								"MULTIPLE_SEPARATOR" => ", "
							),
							$component, array('HIDE_ICONS'=>'Y')
						);?>
					</div>
				</div>
			<?endif;?>
		<?elseif($strGrupperType == "YENISITE_GRUPPER"):?>
			<?if($arResult['CHARACTERISTICS']):?>
				<div class="props_block bordered rounded-4">
					<div class="props_block__wrapper">
						<?$APPLICATION->IncludeComponent(
							'yenisite:ipep.props_groups',
							'',
							array(
								'DISPLAY_PROPERTIES' => $arResult['CHARACTERISTICS'],
								'IBLOCK_ID' => $arParams['IBLOCK_ID']
							),
							$component, array('HIDE_ICONS'=>'Y')
						)?>
					</div>
				</div>
			<?endif;?>
		<?else:?>
			<?/*if($arParams["PROPERTIES_DISPLAY_TYPE"] != "TABLE"):?>
				<div class="props_block">
					<div class="props_block__wrapper flexbox row">
						<?foreach($arResult["CHARACTERISTICS"] as $propCode => $arProp):?>
							<div class="char col-lg-3 col-md-4 col-xs-6 bordered">
								<div class="char_name font_15 color_666">
									<div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
										<span><?=$arProp["NAME"]?></span>
									</div>
									<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint hint--down"><span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
								</div>
								<div class="char_value font_15 color_333">
									<?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
										<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
									<?else:?>
										<?=$arProp["DISPLAY_VALUE"];?>
									<?endif;?>
								</div>
							</div>
						<?endforeach;?>
					</div>
				</div>
			<?else:*/?>
				<div class="props_block props_block--table props_block--line props_block--nbg bordered rounded-4">
					<table class="props_block__wrapper">
						<?foreach($arResult["CHARACTERISTICS"] as $arProp):?>
							<tr class="char">
								<td class="char_name font_15 color_666">
									<div class="props_item<?=$arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y" ? ' whint' : '';?>">
										<span><?=$arProp["NAME"]?></span>
										<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint hint--down"><span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
									</div>
								</td>
								<td class="char_value font_15 color_333">
									<span>
										<?if (is_array($arProp["DISPLAY_VALUE"])):?>
											<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
										<?else:?>
											<?=$arProp["DISPLAY_VALUE"];?>
										<?endif;?>
									</span>
								</td>
							</tr>
						<?endforeach;?>
					</table>
				</div>
			<?/*endif;*/?>
		<?endif;?>
	<?$this->EndViewTarget();?>
<?endif;?>

<?// files?>
<?$templateData['DOCUMENTS'] = boolval($arResult['DOCUMENTS']);?>
<?if($templateData['DOCUMENTS']):?>
	<?$this->SetViewTarget('PRODUCT_FILES_INFO');?>
		<div class="doc-list-inner__list  grid-list  grid-list--items-1 grid-list--no-gap ">
			<?foreach($arResult['DOCUMENTS'] as $arItem):?>
				<?
				$arDocFile = TSolution::GetFileInfo($arItem);
				$docFileDescr = $arDocFile['DESCRIPTION'];
				$docFileSize = $arDocFile['FILE_SIZE_FORMAT'];
				$docFileType = $arDocFile['TYPE'];
				$bDocImage = false;
				if ($docFileType == 'jpg' || $docFileType == 'jpeg' || $docFileType == 'bmp' || $docFileType == 'gif' || $docFileType == 'png') {
					$bDocImage = true;
				}
				?>
				<div class="doc-list-inner__wrapper grid-list__item colored_theme_hover_bg-block grid-list-border-outer fill-theme-parent-all">
					<div class="doc-list-inner__item height-100 rounded-4 shadow-hovered shadow-no-border-hovered">
						<?if($arDocFile):?>
							<div class="doc-list-inner__icon-wrapper">
								<a class="file-type doc-list-inner__icon">
									<i class="file-type__icon file-type__icon--<?=$docFileType?>"></i>
								</a>
							</div>
						<?endif;?>
						<div class="doc-list-inner__content-wrapper">
							<div class="doc-list-inner__top">
								<?if($arDocFile):?>
									<?if($bDocImage):?>
										<a href="<?=$arDocFile['SRC']?>" class="doc-list-inner__name fancy dark_link color-theme-target switcher-title" data-caption="<?=htmlspecialchars($docFileDescr)?>"><?=$docFileDescr?></a>
									<?else:?>
										<a href="<?=$arDocFile['SRC']?>" target="_blank" class="doc-list-inner__name dark_link color-theme-target switcher-title" title="<?=htmlspecialchars($docFileDescr)?>">
											<?=$docFileDescr?>
										</a>
									<?endif;?>
									<div class="doc-list-inner__label"><?=$docFileSize?></div>
								<?else:?>
									<div class="doc-list-inner__name switcher-title"><?=$docFileDescr?></div>
								<?endif;?>
								<?if($arDocFile):?>
									<?if($bDocImage):?>
										<a class="doc-list-inner__icon-preview-image doc-list-inner__link-file fancy fill-theme-parent" data-caption="<?= htmlspecialchars($docFileDescr)?>" href="<?=$arDocFile['SRC']?>">
											<?=TSolution::showIconSvg('image-preview fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/preview_image.svg');?>
										</a>
									<?else:?>
										<a class="doc-list-inner__icon-preview-image doc-list-inner__link-file fill-theme-parent" target="_blank" href="<?=$arDocFile['SRC']?>">
											<?=TSolution::showIconSvg('image-preview fill-theme-target', SITE_TEMPLATE_PATH.'/images/svg/file_download.svg');?>
										</a>
									<?endif;?>
								<?endif;?>
							</div>
						</div>
					</div>
				</div>
			<?endforeach;?>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>

<?if(!$bTopWide && !$bTopNarrow):?>
	<?=$detailInfoHtml?>
<?endif;?>
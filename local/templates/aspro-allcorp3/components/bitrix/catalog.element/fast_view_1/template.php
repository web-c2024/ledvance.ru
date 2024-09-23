<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);

global $arTheme;
use \Bitrix\Main\Localization\Loc;

$bOrderViewBasket = $arParams['ORDER_VIEW'];
$basketURL = isset($arTheme['BASKET_PAGE_URL']) && strlen(trim($arTheme['BASKET_PAGE_URL']['VALUE'])) ? $arTheme['BASKET_PAGE_URL']['VALUE'] : SITE_DIR.'cart/';
$dataItem = $bOrderViewBasket ? TSolution::getDataItem($arResult) : false;
$bOrderButton = $arResult['PROPERTIES']['FORM_ORDER']['VALUE_XML_ID'] == 'YES';
$bAskButton = $arResult['PROPERTIES']['FORM_QUESTION']['VALUE_XML_ID'] == 'YES';
$bOcbButton = $arParams['SHOW_ONE_CLINK_BUY'] != 'N';
$cntVisibleChars = intval($arParams['VISIBLE_PROP_COUNT']) > 0 ? intval($arParams['VISIBLE_PROP_COUNT']) : 6;

/*set array props for component_epilog*/
$templateData = array(
	'DETAIL_PAGE_URL' => $arResult['DETAIL_PAGE_URL'],
	'ORDER' => $bOrderViewBasket,
	'SKU' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_SKU')),
);

$article = $arResult['DISPLAY_PROPERTIES']['ARTICLE']['VALUE'];
$status = $arResult['DISPLAY_PROPERTIES']['STATUS']['VALUE'];
$statusCode = $arResult['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID'];

/* sku replace start */
$arCurrentOffer = $arResult['SKU']['CURRENT'];

if ($arCurrentOffer) {
	$oid = \Bitrix\Main\Config\Option::get(VENDOR_MODULE_ID, 'CATALOG_OID', 'oid');
	if ($oid) {
		$arResult['DETAIL_PAGE_URL'].= '?'.$oid.'='.$arCurrentOffer['ID'];
		$arCurrentOffer['DETAIL_PAGE_URL'] = $arResult['DETAIL_PAGE_URL'];
	}

	if ($arCurrentOffer["DISPLAY_PROPERTIES"]["ARTICLE"]["VALUE"]) {
		$article = $arCurrentOffer['DISPLAY_PROPERTIES']['ARTICLE']['VALUE'];
	}
	if ($arCurrentOffer["DISPLAY_PROPERTIES"]["STATUS"]["VALUE"]) {
		$status = $arCurrentOffer['DISPLAY_PROPERTIES']['STATUS']['VALUE'];
		$statusCode = $arCurrentOffer['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID'];
	}

	$arResult["DISPLAY_PROPERTIES"]["FORM_ORDER"] = $arCurrentOffer["DISPLAY_PROPERTIES"]["FORM_ORDER"];
	$arResult["DISPLAY_PROPERTIES"]["PRICE"] = $arCurrentOffer["DISPLAY_PROPERTIES"]["PRICE"];

	if ($arParams['SHOW_SKU_DESCRIPTION'] === 'Y') {		
		if (strlen($arCurrentOffer["PREVIEW_TEXT"])) {
			$arResult["PREVIEW_TEXT"] = $arCurrentOffer["PREVIEW_TEXT"];
			$arResult["PREVIEW_TEXT_TYPE"] = $arCurrentOffer["PREVIEW_TEXT_TYPE"];
		}

		if (strlen($arCurrentOffer["DETAIL_TEXT"])) {
			$arResult["DETAIL_TEXT"] = $arCurrentOffer["DETAIL_TEXT"];
			$arResult["DETAIL_TEXT_TYPE"] = $arCurrentOffer["DETAIL_TEXT_TYPE"];
		}
	}
	
	$arResult['OFFER_PROP'] = TSolution::PrepareItemProps($arCurrentOffer['DISPLAY_PROPERTIES']);
	
	$dataItem = ($bOrderViewBasket ? TSolution::getDataItem($arCurrentOffer) : false);

	$templateData['CURRENT_SKU'] = [
		'ID' => $arCurrentOffer['ID'],
		'PAGE_TITLE' => $pageTitle = $arCurrentOffer['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] ?? $arCurrentOffer['NAME'],
		'META_TITLE' => $arCurrentOffer['IPROPERTY_VALUES']['ELEMENT_META_TITLE'] ?? $pageTitle,
	];

	if ($arParams['CHANGE_TITLE_ITEM_DETAIL'] === 'Y') {
		$arResult['NAME'] = $templateData['CURRENT_SKU']['PAGE_TITLE'];
		$arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] = $arCurrentOffer['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'];
	}
}

$bOrderButton = ($arResult["DISPLAY_PROPERTIES"]["FORM_ORDER"]["VALUE_XML_ID"] == "YES");
/* sku replace end */
?>

<?// detail description?>
<?$templateData['DETAIL_TEXT'] = boolval(strlen($arResult['DETAIL_TEXT']));?>
<?if(strlen($arResult['DETAIL_TEXT'])):?>
	<?$this->SetViewTarget('PRODUCT_DETAIL_TEXT_INFO');?>
		<div class="content catalog-detail__detailtext" itemprop="description">
			<?=$arResult['DETAIL_TEXT'];?>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>

<?// props content?>
<?$templateData['CHARACTERISTICS'] = boolval($arResult['CHARACTERISTICS']);?>
<?if($arResult['CHARACTERISTICS']):?>
	<?$this->SetViewTarget('PRODUCT_PROPS_INFO');?>
		<?$strGrupperType = $arParams["GRUPPER_PROPS"];?>
		<?if($strGrupperType == "GRUPPER"):?>
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
		<?elseif($strGrupperType == "WEBDEBUG"):?>
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
		<?elseif($strGrupperType == "YENISITE_GRUPPER"):?>
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
		<?else:?>
			<?if($arParams["PROPERTIES_DISPLAY_TYPE"] != "TABLE"):?>
				<div class="props_block">
					<div class="props_block__wrapper flexbox row js-offers-prop">
						<?foreach($arResult["CHARACTERISTICS"] as $propCode => $arProp):?>
							<div class="char col-lg-3 col-md-4 col-xs-6 bordered js-prop-replace" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
								<div class="char_name font_15 color_666">
									<div class="props_item js-prop-title <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
										<span itemprop="name"><?=$arProp["NAME"]?></span>
									</div>
									<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint hint--down"><span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
								</div>
								<div class="char_value font_15 color_333 js-prop-value" itemprop="value">
									<?if(count($arProp["DISPLAY_VALUE"]) > 1):?>
										<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
									<?else:?>
										<?=$arProp["DISPLAY_VALUE"];?>
									<?endif;?>
								</div>
							</div>
						<?endforeach;?>
						<?if ($arResult['OFFER_PROP']):?>
							<?foreach($arResult["OFFER_PROP"] as $propCode => $arProp):?>
								<div class="char col-lg-3 col-md-4 col-xs-6 bordered js-prop" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
									<div class="char_name font_15 color_666">
										<div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
											<span itemprop="name"><?=$arProp["NAME"]?></span>
										</div>
										<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint hint--down"><span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
									</div>
									<div class="char_value font_15 color_333" itemprop="value">
										<?if(count($arProp["VALUE"]) > 1):?>
											<?=implode(', ', $arProp["VALUE"]);?>
										<?else:?>
											<?=$arProp["VALUE"];?>
										<?endif;?>
									</div>
								</div>
							<?endforeach;?>
						<?endif;?>
					</div>
				</div>
			<?else:?>
				<div class="props_block props_block--table props_block--nbg bordered rounded-4">
					<table class="props_block__wrapper ">
						<tbody class="js-offers-prop">
							<?foreach($arResult["CHARACTERISTICS"] as $arProp):?>
								<tr class="char js-prop-replace" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
									<td class="char_name font_15 color_666">
										<div class="props_item js-prop-title <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
											<span itemprop="name"><?=$arProp["NAME"]?></span>
											<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint hint--down"><span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
										</div>
									</td>
									<td class="char_value font_15 color_333 js-prop-value">
										<span itemprop="value">
											<?if(is_array($arProp["DISPLAY_VALUE"]) && count($arProp["DISPLAY_VALUE"]) > 1):?>
												<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
											<?else:?>
												<?=$arProp["DISPLAY_VALUE"];?>
											<?endif;?>
										</span>
									</td>
								</tr>
							<?endforeach;?>
							<?if ($arResult['OFFER_PROP']):?>
								<?foreach($arResult["OFFER_PROP"] as $arProp):?>
									<tr class="char js-prop" itemprop="additionalProperty" itemscope itemtype="http://schema.org/PropertyValue">
										<td class="char_name font_15 color_666">
											<div class="props_item <?if($arProp["HINT"] && $arParams["SHOW_HINTS"] == "Y"){?>whint<?}?>">
												<span itemprop="name"><?=$arProp["NAME"]?></span>
												<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?><div class="hint hint--down"><span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span><div class="tooltip"><?=$arProp["HINT"]?></div></div><?endif;?>
											</div>
										</td>
										<td class="char_value font_15 color_333">
											<span itemprop="value">
												<?if(is_array($arProp["DISPLAY_VALUE"]) && count($arProp["VALUE"]) > 1):?>
													<?=implode(', ', $arProp["VALUE"]);?>
												<?else:?>
													<?=$arProp["VALUE"];?>
												<?endif;?>
											</span>
										</td>
									</tr>
								<?endforeach;?>
							<?endif;?>
						</tbody>
					</table>
				</div>
			<?endif;?>
		<?endif;?>
	<?$this->EndViewTarget();?>
<?endif;?>

<?$this->SetViewTarget('PRODUCT_SIDE_INFO');?>
	<?ob_start();?>
	<div class="catalog-detail__buy-block" itemprop="offers" itemscope itemtype="http://schema.org/Offer" data-id="<?=$arResult['ID']?>"<?=($bOrderViewBasket ? ' data-item="'.$dataItem.'"' : '')?>>
		<?if(
			$arParams['SHOW_DISCOUNT_TIME'] == 'Y' &&
			$arResult['DISPLAY_PROPERTIES']['DATE_COUNTER']['VALUE']
		):?>
			<?TSolution\Functions::showDiscountCounter([
				'TYPE' => 'type-1',
				'ICONS' => true,
				'DATE' => $arResult['DISPLAY_PROPERTIES']['DATE_COUNTER']['VALUE'],
				'ITEM' => $arResult
			]);?>
		<?endif;?>

		<a href="<?=$arResult['DETAIL_PAGE_URL']?>" class="catalog-detail__title js-popup-title switcher-title font_24 dark_link"><?=$arResult['NAME']?></a>

		<?
		$bShowBrand = $arResult['BRAND_ITEM'] && $arResult['BRAND_ITEM']['IMAGE'];
		?>
		<?if(
			strlen($status) || 
			strlen($article) ||
			$bShowBrand
		):?>
			<div class="catalog-detail__info-tech">
				<div class="line-block line-block--20 flexbox--wrap">
					<?if(
						strlen($status) ||
						strlen($article)
					):?>
						<div class="line-block__item">
							<div class="line-block line-block--20 flexbox--wrap js-popup-info">
								<?// element status?>
								<?if(strlen($status)):?>
									<div class="line-block__item font_13">
										<?if ($bUseSchema):?>
											<?=TSolution\Functions::showSchemaAvailabilityMeta($statusCode);?>
										<?endif;?>
										<span 
											class="status-icon <?=$statusCode?> js-replace-status" 
											data-state="<?=$statusCode?>"
											data-code="<?=$arResult['DISPLAY_PROPERTIES']['STATUS']['VALUE_XML_ID']?>" 
											data-value="<?=$arResult['DISPLAY_PROPERTIES']['STATUS']['VALUE']?>"
										><?=$status?></span>
									</div>
								<?endif;?>

								<?// element article?>
								<?if(strlen($article)):?>
									<div class="line-block__item font_13 color_999">
										<span class="article"><?=GetMessage('S_ARTICLE')?>&nbsp;<span 
											class="js-replace-article"
											data-value="<?=$arResult['DISPLAY_PROPERTIES']['ARTICLE']['VALUE']?>"
										><?=$article?></span></span>
									</div>
								<?endif;?>
							</div>
						</div>
					<?endif;?>

					<?// brand?>
					<?if($bShowBrand):?>
						<div class="line-block__item brand-detail">
							<div class="line-block__item brand-detail-info">
								<div class="brand-detail-info__image"><a href="<?=$arResult['BRAND_ITEM']["DETAIL_PAGE_URL"];?>"><img src="<?=$arResult['BRAND_ITEM']['IMAGE']["src"];?>" alt="<?=$arResult['BRAND_ITEM']["NAME"];?>" title="<?=$arResult['BRAND_ITEM']["NAME"];?>" itemprop="image"></a></div>
							</div>
						</div>
					<?endif;?>
				</div>
			</div>
		<?endif;?>

		<div class="line-block line-block--20 line-block--16-vertical line-block--align-normal flexbox--wrap flexbox--justify-beetwen">
			<div class="line-block__item catalog-detail__price js-popup-price">
				<?=TSolution\Functions::showPrice([
					'ITEM' => ($arCurrentOffer ? $arCurrentOffer : $arResult),
					'PARAMS' => $arParams,
					'SHOW_SCHEMA' => true,
					'BASKET' => $bOrderViewBasket,
				]);?>
			</div>
		</div>

		<?if ($arResult['SKU']['PROPS']):?>
			<div class="catalog-block__offers1">
				<div 
				class="sku-props sku-props--detail"
				data-site-id="<?=SITE_ID;?>"
				data-item-id="<?=$arResult['ID'];?>"
				data-iblockid="<?=$arResult['IBLOCK_ID'];?>"
				data-offer-id="<?=$arCurrentOffer['ID'];?>"
				data-offer-iblockid="<?=$arCurrentOffer['IBLOCK_ID'];?>"
				>
					<div class="line-block line-block--flex-wrap line-block--flex-100 line-block--40 line-block--align-flex-end">
						<?=TSolution\CSKUTemplate::showSkuPropsHtml($arResult['SKU']['PROPS'])?>
					</div>
				</div>
			</div>
		<?endif;?>

		<?$arBtnConfig = [
			'DETAIL_PAGE' => true,
			'BASKET_URL' => false,
			'BASKET' => $bOrderViewBasket,
			'ORDER_BTN' => $bOrderButton,
			'BTN_CLASS' => 'btn-lg',
			'BTN_CLASS_MORE' => 'bg-theme-target border-theme-target btn-wide',
			'BTN_IN_CART_CLASS' => 'btn-lg btn-wide',
			'BTN_CALLBACK_CLASS' => 'btn-transparent-border',
			'BTN_OCB_CLASS' => 'btn-transparent-border btn-ocb',
			'SHOW_COUNTER' => false,
			'ONE_CLICK_BUY' => $bOcbButton,
			'QUESTION_BTN' => $bAskButton,
			'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
			'CATALOG_IBLOCK_ID' => $arResult['IBLOCK_ID'],
			'ITEM_ID' => $arResult['ID'],
			'ASK_FORM_ID' => $arParams['ASK_FORM_ID'],
		];?>
		<div class="catalog-detail__cart js-replace-btns js-config-btns" data-btn-config='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arBtnConfig, false, true))?>'>
			<?=TSolution\Functions::showBasketButton(
				array_merge(
					(array)$arBtnConfig, 
					[
						'ITEM' => ($arCurrentOffer ? $arCurrentOffer : $arResult),
						'PARAMS' => $arParams,
					]
				)
			);?>
		</div>

		<?if(strlen(trim($arResult['INCLUDE_CONTENT']))):?>
			<div class="catalog-detail__garanty block-with-icon">
				<?=TSolution::showIconSvg("icon block-with-icon__icon", SITE_TEMPLATE_PATH.'/images/svg/catalog/info_big.svg', '', '', true, false);?>
				<div class="block-with-icon__text font_13 font_666">
					<?=$arResult['INCLUDE_CONTENT']?>
				</div>
			</div>
		<?endif;?>
	</div>
	<?=$buyBlockHtml = ob_get_clean();?>
<?$this->EndViewTarget();?>

<div class="form flex-1">
	<div class="catalog-detail__top-info flexbox flexbox--direction-row flexbox--wrap-nowrap">
		<? //meta?>
		<meta itemprop="name" content="<?=$name = strip_tags(!empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']) ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] : $arResult['NAME'])?>" />
		<link itemprop="url" href="<?=$arResult['DETAIL_PAGE_URL']?>" />
		<meta itemprop="category" content="<?=$arResult['CATEGORY_PATH']?>" />
		<meta itemprop="description" content="<?=(strlen(strip_tags($arResult['PREVIEW_TEXT'])) ? strip_tags($arResult['PREVIEW_TEXT']) : (strlen(strip_tags($arResult['DETAIL_TEXT'])) ? strip_tags($arResult['DETAIL_TEXT']) : $name))?>" />
		<meta itemprop="sku" content="<?=$arResult['ID'];?>" />

		<?if ($arResult['SKU_CONFIG']):?><div class="js-sku-config" data-value='<?=str_replace('\'', '"', CUtil::PhpToJSObject($arResult['SKU_CONFIG'], false, true))?>'></div><?endif;?>
		
		<?
		$topGallery = new TSolution\Product\DetailGallery([
			'ITEM' => $arResult,
			'CURRENT_OFFER' => $arCurrentOffer,
			'PARAMS' => $arParams,
			'SHOW_THUMBS' => false,
			'DETAIL_BUTTON' => true,
			'INNER_WRAPPER' => 'catalog-detail__gallery-inner',
		]);
		$topGallery->show();
		?>
		<div class="catalog-detail__main scrollbar">
			<div class="catalog-detail__main-wrapper">
				<?=$buyBlockHtml?>

				<?if(strlen($arResult['PREVIEW_TEXT'])):?>
					<div class="catalog-detail__previewtext" itemprop="description">
						<div class="text-block font_14 color_666">
							<?// element preview text?>
							<?if($arResult['PREVIEW_TEXT_TYPE'] == 'text'):?>
								<p><?=$arResult['PREVIEW_TEXT']?></p>
							<?else:?>
								<?=$arResult['PREVIEW_TEXT']?>
							<?endif;?>
						</div>
					</div>
				<?endif;?>

				<?if($arResult['CHARACTERISTICS']):?>
					<div class="char-side">
						<div class="char-side__title font_15 color_333 font-bold"><?=($arParams["T_CHARACTERISTICS"] ? $arParams["T_CHARACTERISTICS"] : Loc::getMessage("T_CHARACTERISTICS"));?></div>
						<div class="properties list font_14">
							<div class="properties__container properties js-offers-prop">
								<?foreach($arResult['CHARACTERISTICS'] as $arProp):?>
									<div class="properties__item js-prop-replace">
										<div class="properties__title properties__item--inline color_666 js-prop-title">
											<?=$arProp['NAME']?>
											<?if($arProp["HINT"] && $arParams["SHOW_HINTS"]=="Y"):?>
												<div class="hint hint--down">
													<span class="hint__icon rounded bg-theme-hover border-theme-hover bordered"><i>?</i></span>
													<div class="tooltip"><?=$arProp["HINT"]?></div>
												</div>
											<?endif;?>
										</div>
										<div class="properties__hr properties__item--inline color_666">&mdash;</div>
										<div class="properties__value color_333 properties__item--inline js-prop-value">
											<?if(is_array($arProp["DISPLAY_VALUE"]) && count($arProp["DISPLAY_VALUE"]) > 1):?>
												<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
											<?else:?>
												<?=$arProp["DISPLAY_VALUE"];?>
											<?endif;?>
										</div>
									</div>
								<?endforeach;?>
								<?if ($arResult['OFFER_PROP']):?>
									<?foreach($arResult['OFFER_PROP'] as $arProp):?>
										<div class="properties__item js-prop">
											<div class="properties__title properties__item--inline color_999">
												<?=$arProp['NAME']?>
											</div>
											<div class="properties__hr properties__item--inline color_666">&mdash;</div>
											<div class="properties__value color_333 properties__item--inline">
												<?if(is_array($arProp["VALUE"]) && count($arProp["VALUE"]) > 1):?>
													<?=implode(', ', $arProp["VALUE"]);?>
												<?else:?>
													<?=$arProp["VALUE"];?>
												<?endif;?>
											</div>
										</div>
									<?endforeach;?>
								<?endif;?>
							</div>
						</div>
					</div>
				<?endif;?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var navs = $('#popup_iframe_wrapper .navigation-wrapper-fast-view .fast-view-nav');
		if(navs.length) {
			var ajaxData = {
				element: "<?=$arResult['ID']?>",
				iblock: "<?=$arParams['IBLOCK_ID']?>",
				section: "<?=$arResult['IBLOCK_SECTION_ID']?>",
			};

			if($('.smart-filter-filter').length && $('.smart-filter-filter').text().length) {
				try {
					var text = $('.smart-filter-filter').text().replace(/var filter\s*=\s*/g, '');
			        JSON.parse(text);
					ajaxData.filter = text;
			    }
				catch (e) {}
			}

			if($('.smart-filter-sort').length && $('.smart-filter-sort').text().length) {
				try {
					var text = $('.smart-filter-sort').text().replace(/var sort\s*=\s*/g, '');
			        JSON.parse(text);
					ajaxData.sort = text;
			    }
				catch (e) {}
			}

			navs.data('ajax', ajaxData);
		}
	</script>
</div>
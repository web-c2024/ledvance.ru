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
$cntVisibleChars = TSolution\Functions::getCountDisplayProperties($arParams['VISIBLE_PROP_COUNT']);

/*set array props for component_epilog*/
$templateData = array(
	'DETAIL_PAGE_URL' => $arResult['DETAIL_PAGE_URL'],
	'ORDER' => $bOrderViewBasket,
	'TIZERS' => array(
		'IBLOCK_ID' => $arResult['PROPERTIES']['LINK_TIZERS']['LINK_IBLOCK_ID'],
		'VALUE' => $arResult['TIZERS'],
	),
	'FAQ' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_FAQ')),
	'REVIEWS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_REVIEWS')),
	'VACANCY' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_VACANCY')),
	'PARTNERS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_PARTNERS')),
	'SALE' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_SALE'), array('LINK_GOODS', 'LINK_GOODS_FILTER')),
	'NEWS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_NEWS'), array('LINK_GOODS', 'LINK_GOODS_FILTER')),
	'STAFF' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_STAFF'), array('LINK_GOODS', 'LINK_GOODS_FILTER')),
	'ARTICLES' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_ARTICLES'), array('LINK_GOODS', 'LINK_GOODS_FILTER')),
	'PROJECTS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_PROJECTS'), array('LINK_GOODS', 'LINK_GOODS_FILTER')),
	'SERVICES' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_SERVICES'), array('LINK_GOODS', 'LINK_GOODS_FILTER')),
	'SKU' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_SKU')),
	'GOODS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_GOODS', 'LINK_GOODS_FILTER'), array('LINK_GOODS')),
	'PRICES' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_PRICES')),
	'TARIFFS' => TSolution\Functions::getCrossLinkedItems($arResult, array('LINK_TARIF')),
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

<?// top banner?>
<?$templateData['SECTION_BNR_CONTENT'] = isset($arResult['PROPERTIES']['BNR_TOP']) && $arResult['PROPERTIES']['BNR_TOP']['VALUE_XML_ID'] == 'YES';?>
<?if($templateData['SECTION_BNR_CONTENT']):?>
	<?
	$templateData['SECTION_BNR_UNDER_HEADER'] = $arResult['PROPERTIES']['BNR_TOP_UNDER_HEADER']['VALUE_XML_ID'];
	$templateData['SECTION_BNR_COLOR'] = $arResult['PROPERTIES']['BNR_TOP_COLOR']['VALUE_XML_ID'];
	$atrTitle = $arResult['PROPERTIES']['BNR_TOP_BG']['DESCRIPTION'] ?: $arResult['PROPERTIES']['BNR_TOP_BG']['TITLE'] ?: $arResult['NAME'];
	$atrAlt = $arResult['PROPERTIES']['BNR_TOP_BG']['DESCRIPTION'] ?: $arResult['PROPERTIES']['BNR_TOP_BG']['ALT'] ?: $arResult['NAME'];
	$atrDop1 = $arResult['PROPERTIES']['BUTTON1ATTR']["VALUE"] ? $arResult['PROPERTIES']['BUTTON1ATTR']["VALUE"] : "";
	$atrDop2 = $arResult['PROPERTIES']['BUTTON2ATTR']["VALUE"] ? $arResult['PROPERTIES']['BUTTON2ATTR']["VALUE"] : "";


	//buttons
	$bannerButtons = [
		[
			'TITLE' => $arResult['PROPERTIES']['BUTTON1TEXT']['VALUE'] ?? '',
			'CLASS' => 'btn choise '.($arResult['PROPERTIES']['BUTTON1CLASS']['VALUE_XML_ID'] ?? 'btn-default').' '.($arResult['PROPERTIES']['BUTTON1COLOR']['VALUE_XML_ID'] ?? ''),
			'ATTR' => [
				($arResult['PROPERTIES']['BUTTON1TARGET']['VALUE_XML_ID'] === 'scroll' || !$arResult['PROPERTIES']['BUTTON1TARGET']['VALUE_XML_ID']
					? 'data-block=".right_block .detail"'
					: 'target="'.$arResult['PROPERTIES']['BUTTON1TARGET']['VALUE_XML_ID'].'"'),
					$atrDop1
			],
			'LINK' => $arResult['PROPERTIES']['BUTTON1LINK']['VALUE'],
			'TYPE' => $arResult['PROPERTIES']['BUTTON1TARGET']['VALUE_XML_ID'] === 'scroll' || !$arResult['PROPERTIES']['BUTTON1TARGET']['VALUE_XML_ID']
				? 'anchor'
				: 'link'
		]
	];

	if( $arResult['PROPERTIES']['BUTTON2TEXT']['VALUE'] && $arResult['PROPERTIES']['BUTTON2LINK']['VALUE'] ){
		$bannerButtons[] = [
			'TITLE' => $arResult['PROPERTIES']['BUTTON2TEXT']['VALUE'],
			'CLASS' => 'btn choise '.($arResult['PROPERTIES']['BUTTON2CLASS']['VALUE_XML_ID'] ?? 'btn-default').' '.($arResult['PROPERTIES']['BUTTON2COLOR']['VALUE_XML_ID'] ?? ''),
			'ATTR' => [
				($arResult['PROPERTIES']['BUTTON2TARGET']['VALUE_XML_ID'] ? 'target="'.$arResult['PROPERTIES']['BUTTON2TARGET']['VALUE_XML_ID'].'"' : ''),
				$atrDop2

			],
			'LINK' => $arResult['PROPERTIES']['BUTTON2LINK']['VALUE'],
			'TYPE' => 'link',
		];
	}
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
						'TYPE' => $arResult['PREVIEW_TEXT_TYPE'],
						'VALUE' => $arResult['PREVIEW_TEXT'],
					)
				),
				'PICTURES' => array(
					'BG' => CFile::GetFileArray($arResult['PROPERTIES']['BNR_TOP_BG']['VALUE']),
					'IMG' => CFile::GetFileArray($arResult['PROPERTIES']['BNR_TOP_IMG']['VALUE']),
				),
				'BUTTONS' => $bannerButtons,
				'ATTR' => array(
					'ALT' => $atrAlt,
					'TITLE' => $atrTitle,
				),
				'TOP_IMG' => $bTopImg
			),
		));?>
	<?$this->EndViewTarget();?>
<?endif;?>

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
									<?if(count((array)$arProp["DISPLAY_VALUE"]) > 1):?>
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
										<?if(count((array)$arProp["VALUE"]) > 1):?>
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
											<?if(count((array)$arProp["DISPLAY_VALUE"]) > 1):?>
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
												<?if(count((array)$arProp["VALUE"]) > 1):?>
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

<?
// event for manipulation of templateData
foreach (GetModuleEvents(VENDOR_MODULE_ID, 'onAsproCatalogElementTemplateData', true) as $arEvent)
	ExecuteModuleEventEx($arEvent, [&$templateData, $arResult, $this]);
?>

<?// big gallery?>
<?$templateData['BIG_GALLERY'] = boolval($arResult['BIG_GALLERY']);?>
<?if($arResult['BIG_GALLERY']):?>
	<?$bShowSmallGallery = $arParams['TYPE_BIG_GALLERY'] === 'SMALL';?>
	<?$this->SetViewTarget('PRODUCT_BIG_GALLERY_INFO');?>
		<?// gallery view swith?>
		<div class="gallery-view_switch">
			<div class="flexbox flexbox--direction-row flexbox--align-center">
				<div class="gallery-view_switch__count color_666 font_13">
					<div class="gallery-view_switch__count-wrapper gallery-view_switch__count-wrapper--small" <?=($bShowSmallGallery ? "" : "style='display:none;'");?>>
						<span class="gallery-view_switch__count-value"><?=count((array)$arResult['BIG_GALLERY']);?></span>
						<?=Loc::getMessage('PHOTO');?>
						<span class="gallery-view_switch__count-separate">&mdash;</span>
					</div>
					<div class="gallery-view_switch__count-wrapper gallery-view_switch__count-wrapper--big" <?=($bShowSmallGallery ? "style='display:none;'" : "");?>>
						<span class="gallery-view_switch__count-value">1/<?=count((array)$arResult['BIG_GALLERY']);?></span>
						<span class="gallery-view_switch__count-separate">&mdash;</span>
					</div>
				</div>
				<div class="gallery-view_switch__icons-wrapper">
					<span class="gallery-view_switch__icons<?=(!$bShowSmallGallery ? ' active' : '')?> gallery-view_switch__icons--big" title="<?=Loc::getMessage("BIG_GALLERY");?>"><?=TSolution::showIconSvg("gallery", SITE_TEMPLATE_PATH."/images/svg/gallery_alone.svg", "", "colored_theme_hover_bg-el-svg", true, false);?></span>
					<span class="gallery-view_switch__icons<?=($bShowSmallGallery ? ' active' : '')?> gallery-view_switch__icons--small" title="<?=Loc::getMessage("SMALL_GALLERY");?>"><?=TSolution::showIconSvg("gallery", SITE_TEMPLATE_PATH."/images/svg/gallery_list.svg", "", "colored_theme_hover_bg-el-svg", true, false);?></span>
				</div>
			</div>
		</div>

		<?// gallery big?>
		<div class="gallery-big"<?=($bShowSmallGallery ? ' style="display:none;"' : '');?> >
			<div class="owl-carousel appear-block owl-carousel--outer-dots owl-carousel--nav-hover-visible owl-bg-nav owl-carousel--light owl-carousel--button-wide owl-carousel--button-offset-half" data-plugin-options='{"items": "1", "autoplay" : false, "autoplayTimeout" : "3000", "smartSpeed":1000, "dots": true, "dotsContainer": false, "nav": true, "loop": false, "index": true, "margin": 0}'>
				<?foreach($arResult['BIG_GALLERY'] as $arPhoto):?>
					<div class="item">
						<a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy" data-fancybox="big-gallery" target="_blank" title="<?=$arPhoto['TITLE']?>">
							<img data-src="<?=$arPhoto['PREVIEW']['src']?>" src="<?=$arPhoto['PREVIEW']['src']?>" class="img-responsive inline lazy rounded-4" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
						</a>
					</div>
				<?endforeach;?>
			</div>
		</div>

		<?// gallery small?>
		<div class="gallery-small"<?=($bShowSmallGallery ? '' : ' style="display:none;"');?>>
			<div class="grid-list grid-list--gap-20">
				<?foreach($arResult['BIG_GALLERY'] as $arPhoto):?>
					<div class="gallery-item-wrapper">
						<div class="item rounded-4">
							<a href="<?=$arPhoto['DETAIL']['SRC']?>" class="fancy" data-fancybox="small-gallery" target="_blank" title="<?=$arPhoto['TITLE']?>">
								<img data-src="<?=$arPhoto['PREVIEW']['src']?>" src="<?=$arPhoto['PREVIEW']['src']?>" class="lazy img-responsive inline rounded-4" title="<?=$arPhoto['TITLE']?>" alt="<?=$arPhoto['ALT']?>" />
							</a>
						</div>
					</div>
				<?endforeach;?>
			</div>
		</div>
	<?$this->EndViewTarget();?>
<?endif;?>

<?// video?>
<?
$templateData['VIDEO'] = boolval($arResult['VIDEO']);
?>
<?if($arResult['VIDEO']):?>
	<?$this->SetViewTarget('PRODUCT_VIDEO_INFO');?>
		<?TSolution\Functions::showBlockHtml([
            'FILE' => 'video/detail_video_block.php',
            'PARAMS' => [
				'VIDEO' => $arResult['VIDEO'],
			],
        ])?>
	<?$this->EndViewTarget();?>
<?endif;?>

<?$this->SetViewTarget('PRODUCT_SIDE_INFO');?>
	<div class="catalog-detail__sticky-panel sticky-block rounded-4">
		<div class="catalog-detail__sticky-panel-wrapper">
			<?ob_start();?>
			<div class="catalog-detail__buy-block" itemprop="offers" itemscope itemtype="http://schema.org/Offer" data-id="<?=$arResult['ID']?>"<?=($bOrderViewBasket ? ' data-item="'.$dataItem.'"' : '')?>>
				<div style="position:relative">
					<div class="catalog-detail__title js-popup-title switcher-title color_333 font_15"><span><?=$arResult['NAME']?></span></div>
				</div>

				<div class="line-block line-block--20 line-block--16-vertical line-block--align-normal flexbox--wrap flexbox--justify-beetwen">
					<div class="line-block__item catalog-detail__price catalog-detail__info--margined js-popup-price">
						<?=TSolution\Functions::showPrice([
							'ITEM' => ($arCurrentOffer ? $arCurrentOffer : $arResult),
							'PARAMS' => $arParams,
							'SHOW_SCHEMA' => true,
							'BASKET' => $bOrderViewBasket,
						]);?>
					</div>

					<div class="line-block__item catalog-detail__countdown catalog-detail__info--margined">
						<?if(
							$arParams["SHOW_DISCOUNT_TIME"] == "Y" &&
							$arResult['DISPLAY_PROPERTIES']['DATE_COUNTER']['VALUE']
						):?>
							<?TSolution\Functions::showDiscountCounter([
								'TYPE' => 'type-1',
								'ICONS' => true,
								'DATE' => $arResult['DISPLAY_PROPERTIES']['DATE_COUNTER']['VALUE'],
								'ITEM' => $arResult
							]);?>
						<?endif;?>
					</div>
				</div>

				<?if (strlen($status) || strlen($article)):?>
					<div class="catalog-detail__info-tech">
						<div class="line-block line-block--20 flexbox--wrap js-popup-info">
							<?// element status?>
							<?if (strlen($status)):?>
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
							<?if (strlen($article)):?>
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
							$arBtnConfig, 
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
			<?//show sale block?>
			<?if($templateData['SALE']['VALUE'] && $templateData['SALE']['IBLOCK_ID']):?>
				<?$GLOBALS['arrSaleFilter'] = array('ID' => $templateData['SALE']['VALUE']);?>
				<?ob_start();?>
					<?$APPLICATION->IncludeComponent(
						"bitrix:news.list",
						"sale-linked",
						array(
							"IBLOCK_TYPE" => "aspro_".VENDOR_SOLUTION_NAME."_content",
							"IBLOCK_ID" => $templateData['SALE']['IBLOCK_ID'],
							"NEWS_COUNT" => "20",
							"SORT_BY1" => "SORT",
							"SORT_ORDER1" => "ASC",
							"SORT_BY2" => "ID",
							"SORT_ORDER2" => "DESC",
							"FILTER_NAME" => "arrSaleFilter",
							"FIELD_CODE" => array(
								0 => "NAME",
								1 => "PREVIEW_TEXT",
								2 => "PREVIEW_PICTURE",
								3 => "DATE_ACTIVE_FROM",
								4 => "ACTIVE_TO",
								5 => "",
							),
							"PROPERTY_CODE" => array(
								0 => "PERIOD",
								1 => "REDIRECT",
								2 => "SALE_NUMBER",
								3 => "",
							),
							"CHECK_DATES" => "Y",
							"DETAIL_URL" => "",
							"AJAX_MODE" => "N",
							"AJAX_OPTION_JUMP" => "N",
							"AJAX_OPTION_STYLE" => "Y",
							"AJAX_OPTION_HISTORY" => "N",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "36000000",
							"CACHE_FILTER" => "Y",
							"CACHE_GROUPS" => "N",
							"PREVIEW_TRUNCATE_LEN" => "",
							"ACTIVE_DATE_FORMAT" => "d.m.Y",
							"SET_TITLE" => "N",
							"SET_STATUS_404" => "N",
							"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
							"ADD_SECTIONS_CHAIN" => "N",
							"HIDE_LINK_WHEN_NO_DETAIL" => "N",
							"PARENT_SECTION" => "",
							"PARENT_SECTION_CODE" => "",
							"INCLUDE_SUBSECTIONS" => "Y",
							"PAGER_TEMPLATE" => ".default",
							"DISPLAY_TOP_PAGER" => "N",
							"DISPLAY_BOTTOM_PAGER" => "Y",
							"PAGER_TITLE" => "",
							"PAGER_SHOW_ALWAYS" => "N",
							"PAGER_DESC_NUMBERING" => "N",
							"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
							"PAGER_SHOW_ALL" => "N",
							"VIEW_TYPE" => "table",
							"BIG_BLOCK" => "Y",
							"COUNT_IN_LINE" => "2",

							"COMPACT" => true,
							"ELEMENT_TITLE" => "",
						),
						false, array("HIDE_ICONS" => "Y")
					);?>
				<?$html = trim(ob_get_clean());?>
				<?if($html && strpos($html, 'error') === false):?>
					<div class="catalog-detail__sale">
						<?=$html?>
					</div>
				<?endif;?>
			<?endif;?>
			<?=$buyBlockHtml = ob_get_clean();?>
		</div>
	</div>
<?$this->EndViewTarget();?>

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
	]);
	$topGallery->show();
	?>

	<div class="catalog-detail__main">
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
				<?if(strlen($arResult['DETAIL_TEXT'])):?>
					<span class="more-char-link font_14">
						<span class="choise dotted" data-block="desc"><?=Loc::getMessage('MORE_TEXT_BOTTOM')?></span>
					</span>
				<?endif;?>
			</div>
		<?endif;?>

		<div class="catalog-detail__main-parts line-block line-block--48">
			<div class="catalog-detail__main-part catalog-detail__main-part--left flex-1 line-block__item">
				<?if($arResult['CHARACTERISTICS'] && $cntVisibleChars):?>
					<div class="char-side">
						<div class="char-side__title font_15 color_333"><?=($arParams["T_CHARACTERISTICS"] ? $arParams["T_CHARACTERISTICS"] : Loc::getMessage("T_CHARACTERISTICS"));?></div>
						<div class="properties list font_14">
							<?
							$cntChars = count((array)$arResult['CHARACTERISTICS']);
							if($cntChars <= $cntVisibleChars){
								$templateData['CHARACTERISTICS'] = false;
							}
							$j = 0;
							?>
							<div class="properties__container properties <?=(!$templateData['CHARACTERISTICS'] ? 'js-offers-prop' : '');?>">
								<?foreach($arResult['CHARACTERISTICS'] as $arProp):?>
									<?if($j < $cntVisibleChars):?>
										<div class="properties__item js-prop-replace">
											<div class="properties__title properties__item--inline color_999 js-prop-title">
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
												<?if(count((array)$arProp["DISPLAY_VALUE"]) > 1):?>
													<?=implode(', ', $arProp["DISPLAY_VALUE"]);?>
												<?else:?>
													<?=$arProp["DISPLAY_VALUE"];?>
												<?endif;?>
											</div>
										</div>
										<?$j++;?>
									<?endif;?>
								<?endforeach;?>
								<?if ($arResult['OFFER_PROP']):?>
									<?foreach($arResult['OFFER_PROP'] as $arProp):?>
										<?if($j < $cntVisibleChars):?>
											<div class="properties__item js-prop">
												<div class="properties__title properties__item--inline color_999">
													<?=$arProp['NAME']?>
												</div>
												<div class="properties__hr properties__item--inline color_666">&mdash;</div>
												<div class="properties__value color_333 properties__item--inline">
													<?if(count((array)$arProp["VALUE"]) > 1):?>
														<?=implode(', ', $arProp["VALUE"]);?>
													<?else:?>
														<?=$arProp["VALUE"];?>
													<?endif;?>
												</div>
											</div>
										<?endif;?>
									<?endforeach;?>
								<?endif;?>
							</div>
						</div>
						<?if($cntChars > $cntVisibleChars):?>
							<span class="more-char-link font_14">
								<span class="choise dotted" data-block="char"><?=Loc::getMessage('MORE_CHAR_BOTTOM');?></span>
							</span>
						<?endif;?>
					</div>
				<?endif;?>

				<?if(
					$arResult['BRAND_ITEM'] ||
					strlen($arResult['INCLUDE_PRICE'])
				):?>
					<div class="catalog-detail__info-bc">
						<?if($arResult['BRAND_ITEM']):?>
							<div class="brand-detail">
								<div class="line-block line-block--24 flexbox--wrap brand-detail-info">
									<?if($arResult['BRAND_ITEM']["IMAGE"]):?>
										<div class="line-block__item">
											<div class="brand-detail-info__image"><a href="<?=$arResult['BRAND_ITEM']["DETAIL_PAGE_URL"];?>"><img src="<?=$arResult['BRAND_ITEM']["IMAGE"]["src"];?>" alt="<?=$arResult['BRAND_ITEM']["NAME"];?>" title="<?=$arResult['BRAND_ITEM']["NAME"];?>" itemprop="image"></a></div>
										</div>
									<?endif;?>
									<div class="line-block__item">
										<div class="brand-detail-info__preview">
											<?/*if($arResult['SECTION']):?>
												<div class="brand-detail-info__link"><a href="<?=$arResult['SECTION']['SECTION_PAGE_URL']?>filter/brand-is-<?=$arResult['BRAND_ITEM']['CODE']?>/apply/" target="_blank"><?=GetMessage("ITEMS_BY_SECTION")?></a></div>
											<?endif;*/?>
											<div class="brand-detail-info__link"><a class="dark_link color-theme-hover font_13" href="<?=$arResult['BRAND_ITEM']["DETAIL_PAGE_URL"];?>" target="_blank"><?=GetMessage("ITEMS_BY_BRAND", array("#BRAND#" => $arResult['BRAND_ITEM']["NAME"]))?></a></div>
										</div>
									</div>
								</div>
							</div>
						<?endif;?>

						<?if(strlen(trim($arResult['INCLUDE_PRICE']))):?>
							<div class="price_txt font_13 color_999">
								<?=$arResult['INCLUDE_PRICE']?>
							</div>
						<?endif;?>
					</div>
				<?endif;?>
			</div>

			<div class="catalog-detail__main-part catalog-detail__main-part--right flex-1 line-block__item js-popup-block-adaptive">
				<?=$buyBlockHtml?>
			</div>
		</div>
	</div>
</div>

<template class="props-template"><?TSolution\Product\Template::showPropView(['VIEW' => TSolution\Product\Template::VIEW_DETAIL]);?></template>
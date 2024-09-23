<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true ) die();?>
<?$this->setFrameMode(true);?>
<?use \Bitrix\Main\Localization\Loc;?>

<div class="company-item <?=$templateName?>-template">
	<?
	$bBottomImg = $arParams['TYPE_BLOCK'] == 'IMG_BOTTOM';
	$bSideImg = $arParams['TYPE_BLOCK'] == 'IMG_SIDE';
	$bShowTizers = ($arParams['TYPE_BLOCK'] != 'IMG_SIDE' && $arParams['TIZERS_IBLOCK_ID'] && $arResult['DISPLAY_PROPERTIES']['LINK_BENEFIT']['VALUE']);
	$bRegion = (is_array($arParams['REGION']) &&  $arParams['REGION']);
	$bWideImg = (isset($arParams['IMAGE_WIDE']) &&  $arParams['IMAGE_WIDE'] == 'Y');
	$bWideBlock = ($bSideImg && $bWideImg);
	$bImageOffset = $arParams['IMAGE_OFFSET'] === 'Y';

	$bHasUrl = (isset($arResult['DISPLAY_PROPERTIES']['URL']) && strlen($arResult['DISPLAY_PROPERTIES']['URL']['VALUE']));
	$bShowBtn = (isset($arResult['DISPLAY_PROPERTIES']['MORE_BUTTON_TITLE']) && strlen($arResult['DISPLAY_PROPERTIES']['MORE_BUTTON_TITLE']['VALUE']) && $bHasUrl);
	$arParams['TITLE'] = ($arResult['DISPLAY_PROPERTIES']['COMPANY_NAME']['VALUE'] ? $arResult['DISPLAY_PROPERTIES']['COMPANY_NAME']['VALUE'] : $arResult['NAME']);
	if ($bRegion && $arParams['REGION']['PROPERTY_COMPANY_TITLE_VALUE']) {
		$arParams['TITLE'] =  $arParams['REGION']['PROPERTY_COMPANY_TITLE_VALUE'];
	}

	$mainText = $dopText = '';
	if ($arResult['FIELDS']['PREVIEW_TEXT']) {
		$mainText = ($bRegion && $arParams['~REGION']['DETAIL_TEXT'] ? $arParams['~REGION']['DETAIL_TEXT'] : $arResult['PREVIEW_TEXT']);
	}
	if ($arResult['FIELDS']['DETAIL_TEXT'] && $arParams['SHOW_ADDITIONAL_TEXT'] == 'Y') {
		$dopText = ($bRegion && $arParams['~REGION']['PREVIEW_TEXT'] ? $arParams['~REGION']['PREVIEW_TEXT'] : $arResult['DETAIL_TEXT']);
	}

	$bImage = strlen($arResult['FIELDS']['PREVIEW_PICTURE']['SRC']);
	$arImage = ($bImage ? CFile::ResizeImageGet($arResult['FIELDS']['PREVIEW_PICTURE']['ID'], array('width' => 2000, 'height' => 2000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true) : array());
	$imageSrc = ($bImage ? $arImage['src'] : '');

	$videoSource = strlen($arResult['PROPERTIES']['VIDEO_SOURCE']['VALUE_XML_ID']) ? $arResult['PROPERTIES']['VIDEO_SOURCE']['VALUE_XML_ID'] : 'LINK';
	$videoSrc = $arResult['PROPERTIES']['VIDEO_SRC']['VALUE'];
	if ($videoFileID = $arResult['PROPERTIES']['VIDEO']['VALUE']) {
		$videoFileSrc = CFile::GetPath($videoFileID);
	}

	$videoPlayer = $videoPlayerSrc = '';
	if ($videoSource == 'LINK' ? strlen($videoSrc) : strlen($videoFileSrc)) {
		$bVideo = true;
		// $bVideoAutoStart = $arResult['PROPERTIES']['VIDEO_AUTOSTART']['VALUE_XML_ID'] === 'YES';
		if (strlen($videoSrc) && $videoSource === 'LINK') {
			// videoSrc available values
			// YOTUBE:
			// https://youtu.be/WxUOLN933Ko
			// <iframe width="560" height="315" src="https://www.youtube.com/embed/WxUOLN933Ko" frameborder="0" allowfullscreen></iframe>
			// VIMEO:
			// https://vimeo.com/211336204
			// <iframe src="https://player.vimeo.com/video/211336204?title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
			// RUTUBE:
			// <iframe width="720" height="405" src="//rutube.ru/play/embed/10314281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>

			$videoPlayer = 'YOUTUBE';
			$videoSrc = htmlspecialchars_decode($videoSrc);
			if (strpos($videoSrc, 'iframe') !== false) {
				$re = '/<iframe.*src=\"(.*)\".*><\/iframe>/isU';
				preg_match_all($re, $videoSrc, $arMatch);
				$videoSrc = $arMatch[1][0];
			}
			$videoPlayerSrc = $videoSrc;

			switch ($videoSrc) {
				case (($v = strpos($videoSrc, 'vimeo.com/')) !== false):
					$videoPlayer = 'VIMEO';
					if (strpos($videoSrc, 'player.vimeo.com/') === false) {
						$videoPlayerSrc = str_replace('vimeo.com/', 'player.vimeo.com/', $videoPlayerSrc);
					}

					if (strpos($videoSrc, 'vimeo.com/video/') === false) {
						$videoPlayerSrc = str_replace('vimeo.com/', 'vimeo.com/video/', $videoPlayerSrc);
					}

					break;
				case (($v = strpos($videoSrc, 'rutube.ru/')) !== false):
					$videoPlayer = 'RUTUBE';
					break;
				case (strpos($videoSrc, 'watch?') !== false && ($v = strpos($videoSrc, 'v=')) !== false):
					$videoPlayerSrc = 'https://www.youtube.com/embed/'.substr($videoSrc, $v + 2, 11);
					break;
				case (strpos($videoSrc, 'youtu.be/') !== false && $v = strpos($videoSrc, 'youtu.be/')):
					$videoPlayerSrc = 'https://www.youtube.com/embed/'.substr($videoSrc, $v + 9, 11);
					break;
				case (strpos($videoSrc, 'embed/') !== false && $v = strpos($videoSrc, 'embed/')):
					$videoPlayerSrc = 'https://www.youtube.com/embed/'.substr($videoSrc, $v + 6, 11);
					break;
			}

			$bVideoPlayerYoutube = $videoPlayer === 'YOUTUBE';
			$bVideoPlayerVimeo = $videoPlayer === 'VIMEO';
			$bVideoPlayerRutube = $videoPlayer === 'RUTUBE';

			if (strlen($videoPlayerSrc)) {
				$videoPlayerSrc = trim($videoPlayerSrc.
					($bVideoPlayerYoutube ? '?autoplay=1&enablejsapi=1&controls=0&showinfo=0&rel=0&disablekb=1&iv_load_policy=3' :
					($bVideoPlayerVimeo ? '?autoplay=1&badge=0&byline=0&portrait=0&title=0' :
					($bVideoPlayerRutube ? '?quality=1&autoStart=0&sTitle=false&sAuthor=false&platform=someplatform' : '')))
				);
			}
		} else {
			$videoPlayer = 'HTML5';
			$videoPlayerSrc = $videoFileSrc;
		}
	}

	$itemPictureClass = 'bg-fix';
	if ($bBottomImg) {
		$itemPictureClass .= ' company-item__picture--mt-89 company-item__picture--BOTTOM';
		if (!$bWideImg || ($bWideImg && $bImageOffset) ){
			$itemPictureClass .= ' rounded-4';
		}
	} else {
		$itemPictureClass .= ' company-item__picture--no-fon';
	}
	if ($bWideImg) {
		$itemPictureClass .= ' company-item__picture--wide';
		if ($bBottomImg) {
			$itemPictureClass .= ' index-block--mb-dynamic';
		}
	}
	$companyItemPictureWrapperClass = '';
	if ($bWideBlock) {
		$companyItemPictureWrapperClass .= ' index-block--mt-dynamic index-block--mb-dynamic company-item__picture-wrapper--wide sticky-block--top-0';
	}
	if (!$bBottomImg && !$bWideImg) {
		$itemPictureClass .= ' company-item__picture--static';
	}

	$itemHeadingClass = ' company-item__heading--'.$arParams['POSITION_IMAGE_BLOCK'];
	if ($bBottomImg) {
		$itemHeadingClass .= ' flexbox--w34-f992';
	} else {
		$itemHeadingClass .= ' flex-1';
	}

	$companyItemTextClass = '';
	if (!$bBottomImg) {
		$companyItemTextClass .= ' index-block__preview';
	}

	?>
	<div class="company-item__wrapper company-item--<?=$arParams['TYPE_BLOCK'];?>">
		<?ob_start();?>
			<?if ($bShowBtn):?>
				<div class="index-block__btn">
					<a href="<?=str_replace('//', '/', SITE_DIR.'/'.$arResult['DISPLAY_PROPERTIES']['URL']['VALUE'])?>" class="btn btn-transparent-border btn-lg">
						<?=$arResult['DISPLAY_PROPERTIES']['MORE_BUTTON_TITLE']['VALUE']?>
					</a>
				</div>
			<?endif;?>
		<?$buttonHtml = ob_get_clean();?>

		<?ob_start();?>
			<?if ($bShowTizers):?>
				<?$GLOBALS['LINK_BENEFIT_COMPANY']['ID'] = $arResult['DISPLAY_PROPERTIES']['LINK_BENEFIT']['VALUE']?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list", 
					"tizers-list", 
					array(
						"IBLOCK_TYPE" => "aspro_allcorp3_content",
						"IBLOCK_ID" => $arParams['TIZERS_IBLOCK_ID'],
						"NEWS_COUNT" => $arParams['COUNT_BENEFIT'],
						"SORT_BY1" => "SORT",
						"SORT_ORDER1" => "ASC",
						"SORT_BY2" => "ID",
						"SORT_ORDER2" => "DESC",
						"FILTER_NAME" => "LINK_BENEFIT_COMPANY",
						"FIELD_CODE" => array(
							0 => "NAME",
							1 => "PREVIEW_TEXT",
							2 => "PREVIEW_PICTURE",
							3 => "DETAIL_PICTURE",
							4 => "DETAIL_TEXT",
						),
						"PROPERTY_CODE" => array(
							0 => "",
							1 => "LINK",
							2 => "TYPE",
							3 => "TIZER_ICON",
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
						"PREVIEW_TRUNCATE_LEN" => "250",
						"ACTIVE_DATE_FORMAT" => "d F Y",
						"SET_TITLE" => "N",
						"SHOW_DETAIL_LINK" => "N",
						"SET_STATUS_404" => "N",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"ADD_SECTIONS_CHAIN" => "N",
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"DISPLAY_TOP_PAGER" => "N",
						"DISPLAY_BOTTOM_PAGER" => "Y",
						"PAGER_TITLE" => "",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => "",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "3600",
						"PAGER_SHOW_ALL" => "N",
						"DISPLAY_DATE" => "Y",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "N",
						"DISPLAY_PREVIEW_TEXT" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"COMPONENT_TEMPLATE" => "tizers-list",
						"SET_BROWSER_TITLE" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_LAST_MODIFIED" => "N",
						"INCLUDE_SUBSECTIONS" => "Y",
						"STRICT_SECTION_CHECK" => "N",
						'ITEMS_OFFSET' => true,
						'IMAGES' => $arParams['IMAGES_TIZERS'],
						'IMAGE_POSITION' => $arParams['IMAGE_POSITION_TIZERS'],
						"PAGER_BASE_LINK_ENABLE" => "N",
						"SHOW_404" => "N",
						"MESSAGE_404" => ""
					),
					false, array("HIDE_ICONS" => "Y")
				);?>
			<?endif;?>
		<?$tizersHtml = ob_get_clean();?>

		<?ob_start();?>
			<?if ($mainText):?>
				<div class="company-item__text <?=$companyItemTextClass;?>"><?=$mainText;?></div>
			<?endif;?>
		<?$mainTextHtml = ob_get_clean();?>
		
		<?ob_start();?>
			<div class="company-item__picture <?=$itemPictureClass;?>" style="background-image: url(<?=$imageSrc?>)">
				<?if($bVideo):?>
					<div class="video-block">
						<div class="video-block__play bg-theme-after">
							<div class="video-block__fancy fancy" rel="nofollow">
								<?if($videoPlayer == 'HTML5'):?>
									<video class="company-item__video" muted playsinline controls loop><source  class="video-content" src="#" data-src="<?=$videoPlayerSrc;?>" type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"' /></video>
								<?else:?>
									<iframe class="company-item__video-iframe" data-src="<?=$videoPlayerSrc;?>"></iframe>
								<?endif;?>
							</div>
						</div>
					</div>
				<?endif;?>
			</div>
		<?$pictureHtml = ob_get_clean();?>
		<?if (!$bWideBlock):?>
		<div class="maxwidth-theme">
		<?endif;?>
			<div class="flexbox flexbox--direction-<?=($arParams['POSITION_IMAGE_BLOCK'] != 'LEFT' ? 'row' : 'row-reverse');?> flexbox--column-t991">
				<div class="company-item__heading <?=$itemHeadingClass;?>">
					<?if ($bWideBlock):?>
						<div class="maxwidth-theme--half">
					<?endif;?>
						<div class="sticky-block flexbox--mb20-t991">
							<?=TSolution\Functions::showTitleInLeftBlock([
								'PARAMS' => $arParams,
								'PATH' => '',
							]);?>
							<?if (!$bBottomImg):?>
								<?=$mainTextHtml;?>
							<?endif;?>
							<?=$buttonHtml;?>
						</div>
					<?if ($bWideBlock):?>
						</div>
					<?endif;?>
				</div>
				<div class="flex-1">
					<?if ($bBottomImg):?>
						<div class="company-item__info company-item__info--mt-n6">
							<?if (!$bSideImg):?>
								<?=$mainTextHtml;?>
							<?endif;?>
							<?if ($tizersHtml):?>
								<div class="company-item__tizers"><?=$tizersHtml;?></div>
							<?endif;?>
						</div>
					<?else:?>
						<?if (!$bWideBlock):?>
						<div class="sticky-block company-item__info">
						<?endif;?>
							<?if ($imageSrc):?>								
								<div class="<?=($bWideBlock ? 'sticky-block' : '');?> company-item__picture-wrapper <?=$companyItemPictureWrapperClass;?>">
									<?=$pictureHtml;?>
								</div>
							<?endif;?>
							<?if (!$bWideBlock):?>
								<?if ($dopText):?>
									<div class="company-item__dop-text company-item--mt-49"><?=$dopText;?></div>
								<?endif;?>
								<?if ($tizersHtml):?>
									<div class="company-item__tizers company-item--mt-49"><?=$tizersHtml;?></div>
								<?endif;?>
							<?endif;?>
						<?if (!$bWideBlock):?>
						</div>
						<?endif;?>
					<?endif;?>
				</div>
			</div>
		<?if (!$bWideBlock):?>
		</div>
		<?endif;?>

		<?if ($imageSrc && $bBottomImg):?>
			<?if (!$bWideImg):?>
				<div class="maxwidth-theme">
			<?elseif($bWideImg && $bImageOffset):?>
				<div class="maxwidth-theme maxwidth-theme--no-maxwidth">
			<?endif;?>

			<?=$pictureHtml;?>

			<?if (!$bWideImg):?>
				</div>
			<?elseif($bWideImg && $bImageOffset):?>
				</div>
			<?endif;?>
		<?endif;?>
			
	</div>
</div>
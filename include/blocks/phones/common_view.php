<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
$arPhones = $arOptions['PHONES'];

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/js/phones.js');
?>
<div class="phones__inner fill-theme-parent<?=$arOptions['WRAPPER_CLASS_LIST'];?>">
	<span class="icon-block__only-icon banner-light-icon-fill menu-light-icon-fill fill-theme-target">
		<?=$arOptions['ICON']['ONLY'];?>
	</span>
	<span class="icon-block__icon banner-light-icon-fill menu-light-icon-fill">
		<?=$arOptions['ICON']['PHONE'];?>
	</span>

	<?if (!$arOptions['SHOW_ONLY_ICON'] && $arPhones):?>
		<a class="phones__phone-link phones__phone-first dark_link banner-light-text menu-light-text icon-block__name" 
		   href="<?=$arPhones[0]['HREF'];?>"
		>
		   <?=$arPhones[0]['PHONE'];?>
		</a>
	<?endif;?>

	<?if ($arOptions['TOTAL_COUNT'] >= 1 || $arOptions['SHOW_ONLY_ICON']):?>
		<div class="phones__dropdown">
			<div class="dropdown dropdown--relative">
				<?foreach ($arPhones as $index => $arItem):?>
					<div class="phones__phone-more dropdown__item color-theme-hover<?=$arItem['WRAPPER_CLASS_LIST'];?>">
						<a class="phones__phone-link dark_link flexbox flexbox--direction-row flexbox--justify-beetwen<?=$arItem['LINK_CLASS_LIST'];?>" rel="nofollow" href="<?=$arItem['HREF'];?>">
							<span class="phones__phone-link-text">
								<?=$arItem['PHONE'];?>
								
								<?if ($arItem['DESCRIPTION']):?>
									<span class="phones__phone-descript phones__dropdown-title"><?=$arItem['DESCRIPTION'];?></span>
								<?endif;?>
							</span>
							
							<?=$arItem['ICON'];?>
						</a>
					</div>
				<?endforeach;?>
				
				<?if ($arOptions['ADDITIONAL_BLOCKS']):?>
					<?foreach ($arOptions['ADDITIONAL_BLOCKS'] as $key => $block):?>
						<?=$block;?>
					<?endforeach;?>
				<?endif?>
			</div>
		</div>
	<?endif;?>

	<?if (!$arOptions['SHOW_ONLY_ICON']):?>
		<span class="more-arrow banner-light-icon-fill menu-light-icon-fill fill-dark-light-block">
			<?=$arOptions['ICON']['MORE_ARROW'];?>
		</span>
	<?endif;?>
</div>
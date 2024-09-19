<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
$arPhones = $arOptions['PHONES'];
?>
<div class="phones__inner phones__inner--with_dropdown <?=$arOptions['CLASS']?> fill-theme-parent">
	<?if ($arOptions['ICON']['PHONE']):?>
		<span class="icon-block__only-icon fill-theme-hover menu-light-icon-fill fill-theme-target">
			<?=$arOptions['ICON']['PHONE'];?>
		</span>
	<?endif;?>

	<div id="mobilephones" class="phones__dropdown">
		<div class="mobilephones__menu-dropdown dropdown dropdown--relative scrollbar mobile-scroll">
			<span class="mobilephones__close stroke-theme-hover" title="<?=$arOptions['ICON']['CLOSE']['TITLE'];?>">
				<?=$arOptions['ICON']['CLOSE']['IMAGE'];?>
			</span>

			<div class="mobilephones__menu-item mobilephones__menu-item--title">
				<span class="color_333 font_18 font_bold">
					<?=$arOptions['TITLE'];?>
				</span>
			</div>

			<?foreach ($arPhones as $arItem):?>
				<div class="mobilephones__menu-item">
					<div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all">
						<a class="dark_link phone" href="<?=$arItem['HREF'];?>" rel="nofollow">
							<span class="mobilephones__menu-item-content flexbox flexbox--direction-row flexbox--justify-beetwen">
								<span class="mobilephones__menu-item-text">
									<span class="font_18"><?=$arItem['PHONE'];?></span>

									<?if ($arItem['DESCRIPTION']):?>
										<span class="font_12 color_999 phones__phone-descript"><?=$arItem['DESCRIPTION'];?></span>
									<?endif;?>
								</span>

								<?=$arItem['ICON'];?>
							</span>
						</a>
					</div>
				</div>
			<?endforeach;?>

			<?if ($arOptions['ADDITIONAL_BLOCKS']):?>
				<?foreach ($arOptions['ADDITIONAL_BLOCKS'] as $key => $block):?>
					<?=$block;?>
				<?endforeach;?>
			<?endif?>
		</div>
	</div>
</div>
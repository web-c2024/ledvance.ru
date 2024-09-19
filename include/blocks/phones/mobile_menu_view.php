<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
$arPhones = $arOptions['PHONES'];

if (!$arPhones) return;
?>
<li class="mobilemenu__menu-item mobilemenu__menu-item--with-icon mobilemenu__menu-item--parent">
	<div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all color-theme-parent-all">
		<a class="dark_link" href="<?=$arPhones[0]['HREF'];?>" rel="nofollow">
			<?=$arOptions['ICONS']['PHONE'];?>

			<span class="font_18"><?=$arPhones[0]['PHONE'];?></span>
			
			<?if (isset($arPhones[0]['DESCRIPTION'])):?>
				<span class="font_12 color_999 phones__phone-descript"><?=$arPhones[0]['DESCRIPTION'];?></span>
			<?endif;?>
			
			<?=$arOptions['ICONS']['TRIANGLE'];?>
		</a>
		<span class="toggle_block"></span>
	</div>
	
	<ul class="mobilemenu__menu-dropdown dropdown">
		<li class="mobilemenu__menu-item mobilemenu__menu-item--back">
			<div class="link-wrapper stroke-theme-parent-all colored_theme_hover_bg-block animate-arrow-hover color-theme-parent-all">
				<a class="arrow-all arrow-all--wide stroke-theme-target" href="" rel="nofollow">
					<?=$arOptions['ICONS']['ARROW_BACK'];?>
					<div class="arrow-all__item-line colored_theme_hover_bg-el"></div>
				</a>
			</div>
		</li>
		
		<li class="mobilemenu__menu-item mobilemenu__menu-item--title">
			<div class="link-wrapper">
				<a class="dark_link" href="">
					<span class="font_18 font_bold"><?=$arOptions['MENU_TITLE'] ?? '';?></span>
				</a>
			</div>
		</li>

		<?foreach ($arPhones as $arItem):?>
			<li class="mobilemenu__menu-item">
				<div class="link-wrapper bg-opacity-theme-parent-hover fill-theme-parent-all">
					<a class="dark_link phone flexbox flexbox--direction-row flexbox--justify-beetwen" href="<?=$arItem['HREF'];?>" rel="nofollow">
						<div class="mobile__menu-item-text text-overflow-elipsis">
							<span class="font_18"><?=$arItem['PHONE'];?></span>
							
							<?if ($arItem['DESCRIPTION']):?>
								<span class="font_12 color_999 phones__phone-descript"><?=$arItem['DESCRIPTION'];?></span>
							<?endif;?>
						</div>

						<?=$arItem['ICON'];?>
					</a>
				</div>
			</li>
		<?endforeach;?>

		<?if ($arOptions['CALLBACK']):?>
			<li class="mobilemenu__menu-item mobilemenu__menu-item--callback">
				<button type="button" 
					class="animate-load btn btn-default btn-transparent-border btn-wide" 
					data-event="jqm" 
					data-param-id="<?=$arOptions['CALLBACK']['DATASET']['PARAM_ID'] ?? '';?>" 
					data-name="<?=$arOptions['CALLBACK']['DATASET']['NAME'] ?? '';?>"
				>
					<?=$arOptions['CALLBACK']['TEXT'] ?? '';?>
				</button>
			</li>
		<?endif;?>
	</ul>
</li>
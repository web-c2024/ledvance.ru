<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//options from TSolution\Functions::showBlockHtml
$arOptions = $arConfig['PARAMS'];
?>
<div class="votes_block with-text">
	<div class="ratings">
		<? for ($i = 1; $i <= 5; $i++) : ?>
			<div class="item-rating" data-message="<?= GetMessage('RATING_MESSAGE_' . $i) ?>">
				<?= TSolution::showIconSvg("star", SITE_TEMPLATE_PATH . "/images/svg/star.svg"); ?>
			</div>
		<? endfor; ?>
	</div>
	<div class="rating_message muted" data-message="<?= GetMessage('RATING_MESSAGE_0') ?>">
		<?= GetMessage('RATING_MESSAGE_0') ?>
	</div>
	<?= $arOptions["HTML_CODE"]; ?>
</div>
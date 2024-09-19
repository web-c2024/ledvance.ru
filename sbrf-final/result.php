<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результат оплаты через сбербанк");
?>
<?$APPLICATION->IncludeComponent(
    "webfly:sbrf.result",
    ".default",
    array(),
    false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
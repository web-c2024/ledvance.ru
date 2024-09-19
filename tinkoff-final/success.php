<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результат оплаты через tinkoff");
?>
Ваш заказ № <?=htmlspecialcharsbx($_REQUEST['OrderId'])?> успешно оплачен

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
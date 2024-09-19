<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Результат оплаты через tinkoff");
?>
В процессе оплаты заказ № <?=htmlspecialcharsbx($_REQUEST['OrderId'])?> возникли ошибки
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';

$success = '';
$errors = [];
$checkOrderSum = checkNumber($_POST['order_sum']);
$checkDeliveryPrice = checkNumber($_POST['delivery_price']);

if (empty ($_POST['order_sum'])) {
	array_push ($errors, 'Введите сумму заказа.');
}
if (!empty ($_POST['order_sum']) && !$checkOrderSum) {
	array_push ($errors,'Сумма заказа должна быть десятичным числом.');
}
if (empty ($_POST['delivery_price'])) {
	array_push ($errors, 'Введите стоимость доставки.');
}
if (!empty ($_POST['delivery_price']) && !$checkDeliveryPrice) {
	array_push ($errors,'Стоимость доставки должна быть десятичным числом.');
}
if (empty ($_POST['delivery_value'])) {
	array_push ($errors, 'Произошла ошибка при заполнении формы.');
}

if (count($errors) === 0) {

	insertDeliveryCustomizations($pdo);
	$success = $_POST['delivery_value'];
}

$data = array(
	'errors'   => $errors,
	'success' => $success,
);
 
echo json_encode($data);
// echo json_encode('hello');
exit();
<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';

$errors = [];

if (!empty ($_POST['product_id'])) {
    if (empty ($_POST["name"])) {
        array_push ($errors, 'введите имя');
    }
    if (empty ($_POST["surname"])) {
        array_push ($errors, 'введите фамилию');
    }
    if (empty ($_POST["email"])) {
        array_push ($errors, 'введите E-mail');
    }
    if (empty ($_POST['phone'])) {
        array_push ($errors,'введите телефонный номер');
    }
}

if (!empty ($_POST['product_id']) && $_POST['delivery'] === 'dev-yes') {
    if (empty ($_POST["home"])) {
        array_push ($errors, 'введите номер дома');
    }
    if (empty ($_POST["street"])) {
        array_push ($errors, 'введите улицу');
    }
    if (empty ($_POST["city"])) {
        array_push ($errors, 'введите город');
    }
    if (empty ($_POST["aprt"])) {
        array_push ($errors, 'введите номер квартиры');
    }
    if (!empty ($_POST["city"]) &&
    !empty ($_POST["street"]) &&
    !checkAddress($pdo) &&
    isset ($_POST['delivery_method_id']) &&
    $_POST['delivery_method_id'] > 1) {
        array_push ($errors, 'наша платная доставка по вашему адресу не предусмотрена');
    }
}

if (count($errors) === 0) {
$dataOrder = dataOrder($pdo, $_POST);
insertOrder($pdo, $dataOrder);
echo json_encode('success');
} else {
    $errors = json_encode($errors);
    echo $errors;
}

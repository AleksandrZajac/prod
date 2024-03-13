<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';

if (isset($_POST['product_id'])) {
    softDeleteProduct($pdo);
    echo json_encode('Товар с ID ' . $_POST['product_id'] . ' успешно удален');
} else {
    echo json_encode('Произошла ошибка удаления');
}

<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';

if (isset($_POST['order-id']) && isset($_POST['order-status'])) {
    $orderId = $_POST['order-id'];
    if ($_POST['order-status'] === 'Выполнено') {
        $status = 1;
    } else {
        $status = 0;
    }

$sql = "UPDATE orders SET status = ? WHERE id = ?";
$stmt= $pdo->prepare($sql);
$stmt->execute([$status, $orderId]);
}

echo json_encode($status);
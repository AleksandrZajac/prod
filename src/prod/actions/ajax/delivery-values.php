<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';

$success = [];
if (isset($_POST['delivery_method_id'])) {
    $showSetting = showSetting($pdo, (int)$_POST['delivery_method_id']);
    echo json_encode($showSetting);
} else {
    echo json_encode('error');
}
exit();
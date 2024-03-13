<?php

$standardDelivery = showDelivery($pdo, 'Стандартная доставка');
$onDayOfPurchase = showDelivery($pdo, 'В день покупки для жителей г. Москва в пределах МКАД');
$deliveryWithFittingInMoskow = showDelivery($pdo, 'Доставка с примеркой перед покупкой по Москве');

require $_SERVER['DOCUMENT_ROOT'] . '/content/delivery.php';
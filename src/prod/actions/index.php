<?php

$quantityInPage = 6; 
$minBasePrice = minBasePrice($pdo);
$maxBasePrice = maxBasePrice($pdo);
$options = options($pdo, $quantityInPage, $minBasePrice, $maxBasePrice);
$products = productFilter($pdo, $options);
$catergories = categories($pdo);
$showDeliveryPrices = showDeliveryPrices($pdo);

require $_SERVER['DOCUMENT_ROOT'] . '/content/index.php';

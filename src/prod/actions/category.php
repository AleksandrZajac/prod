<?php

$quantityInPage = 6; 
$minBasePrice = minBasePrice($pdo);
$maxBasePrice = maxBasePrice($pdo);
$options = options($pdo, $quantityInPage, $minBasePrice, $maxBasePrice);
$products = productFilter($pdo, $options);
$catergories = categories($pdo);
$catergories = isActiveCategory($menu, $catergories);
$showDeliveryPrices = showDeliveryPrices($pdo);

require $_SERVER['DOCUMENT_ROOT'] . '/content/category.php';
<?php

$quantityInPage = 6; 
$filterId = 1;
$minBasePrice = minBasePrice($pdo);
$maxBasePrice = maxBasePrice($pdo);
$options = options($pdo, $quantityInPage, $minBasePrice, $maxBasePrice, $filterId);
$products = productFilter($pdo, $options, $filterId);
$catergories = categories($pdo);
$catergories = isActiveCategory($menu, $catergories);
$showDeliveryPrices = showDeliveryPrices($pdo);

require $_SERVER['DOCUMENT_ROOT'] . '/content/new-category.php';
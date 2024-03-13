<?php

$product = selectProductById($pdo);
$category = explode(',', $product['category']);
$filter = explode(',', $product['filter']);

require $_SERVER['DOCUMENT_ROOT'] . '/content/update-product.php';
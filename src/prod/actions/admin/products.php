<?php

$quantityInPage = 5; 

$productOptions = productPaginator($pdo, $quantityInPage);
$productsList = productsList($pdo, $productOptions);

foreach ($productsList as $key => $value) {
    $category = explode(",", $value['category']);
    unset($category[array_search('Все', $category)]);
    $productsList[$key]['category'] = $category;
    $filter = explode(",", $value['filter']);
    unset($filter[array_search('Все товары', $filter)]);
    $productsList[$key]['filter'] = $filter;
}

require $_SERVER['DOCUMENT_ROOT'] . '/content/products.php';
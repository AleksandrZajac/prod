<?php

$mainMenu = [
    [
        'title' => 'Главная',
        'path' => '/',
        'action' => '/actions/index.php',
        'user_status' => 1,
    ],
    [
        'title' => 'Новинка',
        'path' => '/new/',
        'action' => '/actions/new.php',
        'user_status' => 1,
    ],
    [
        'title' => '',
        'path' => newCategoryPaths($pdo),
        'action' => '/actions/new-category.php',
        'user_status' => 1,
    ],
    [
        'title' => 'Sale',
        'path' => '/sale/',
        'action' => '/actions/sale.php',
        'user_status' => 1,
    ],
    [
        'title' => '',
        'path' => saleCategoryPaths($pdo),
        'action' => '/actions/sale-category.php',
        'user_status' => 1,
    ],
    [
        'title' => 'Доставка',
        'path' => '/delivery',
        'action' => '/actions/delivery.php',
        'user_status' => 1,
    ],
    [
        'title' => 'Настройки',
        'path' => '/admin/delivery/customization',
        'action' => '/actions/admin/delivery-customization.php',
        'user_status' => 3,
    ],
    [
        'title' => 'Заказы',
        'path' => '/admin/orders',
        'action' => '/actions/admin/orders.php',
        'user_status' => 2,
    ],
    [
        'title' => 'Продукты',
        'path' => '/admin/products/',
        'action' => '/actions/admin/products.php',
        'user_status' => 3,
    ],
    [
        'title' => 'Logout',
        'path' => '/?logout=yes',
        'user_status' => 2,
    ],
    [
        'title' => '',
        'path' => '/admin/add-product',
        'action' => '/actions/admin/add-product.php',
        'user_status' => 3,
    ],
    [
        'title' => '',
        'path' => '/admin/update-product/',
        'action' => '/actions/admin/update-product.php',
        'user_status' => 3,
    ],
    [
        'title' => '',
        'path' => '/admin',
        'action' => '/actions/admin/authorization_view.php',
        'user_status' => toggleUserStatus(),
    ],
    [
        'title' => '',
        'path' => categoryPaths($pdo),
        'action' => '/actions/category.php',
        'user_status' => 1,
    ]
];

if  (isset($_SESSION['login'])) {
	$menu = mainMenu($pdo, $mainMenu, $_SESSION['login']);
} else {
	$menu = mainMenu($pdo, $mainMenu);
}

$titleList = isActiveTitle($menu);
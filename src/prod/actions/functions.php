<?php

/**
 * Функция сравнивает текущий Uri с элементом массива
 * @param string $value элемент массива меню
 * @return bool возвращает true или false
 */
function isCurrentUrl($value): bool
{
    return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === $value;
}

/**
 * Функция показывает текущий контент из меню разделов
 * @param array $menu отсортированный массив меню
 * @return string $value['content'] возвращает строку путь к контенту
 */
function showContent($menu): string
{
    foreach ($menu as $value) {
        if (isCurrentUrl($value['path'])) {
            return $value['action'];
        }
    }
    return '/content/error.php';
}

/**
 * Функция показывает текущий заголовок из меню разделов
 * @param array $menu отсортированный массив меню
 * @return string $value['title'] возвращает title
 */
function showHeading($menu): string
{
    foreach ($menu as $value) {
        if (isCurrentUrl($value['path'])) {
            return $value['title'];
        }
    }
    return "Страница не найдена.";
}

/**
 * Функция возвращает объект $pdo
 * @param string $host название хоста
 * @param string $db название базы данных
 * @param string $user имя пользователя БД
 * @param string $pass пароль пользователя БД
 * @param string $charset чарсет
 * @return object возвращает объект $pdo
 */
function getConnection($host, $db, $user, $pass, $charset)
{
    static $pdo;
    if (empty($pdo)) {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($dsn, $user, $pass, $opt);
    }
    return $pdo;
}

/**
 * Функция возвращает массив с id, паролями и емайлами из таблицы users
 * @param object $pdo объект
 * @param string $email емайл
 * @return array $users возвращает массив с id, паролем и емайлом из таблицы users
 */
function getUser($pdo, $email): array
{
    $stmt = $pdo->prepare("SELECT id, email, password FROM `users` WHERE email = ?");
    $stmt->execute(array($email));
    $email = $stmt->fetchAll();
    return $email;
}

/**
 * Функция устанавливает куки
 * @param object $pdo объект
 * @param array $users массив с емайлами и паролями пользователя из БД
 * @param string $email емайл пользователя
 * @param string $password пароль пользователя
 */
function setCookies($pdo, $users, $email, $password)
{
    if (
        !empty($users) && $users[0]['email'] === $email
        && password_verify($password, $users[0]['password'])
    ) {
        $_SESSION['login'] = $email;
        setcookie('login', $email, time() + 60 * 60 * 24 * 30, '/');
    }
}

function toggleUserStatus()
{
    if (!empty($_SESSION['login'])) {
        $userStatus = 4;
    } else {
        $userStatus = 1;
    }
    return $userStatus;
}

function categories($pdo)
{
    $stmt = $pdo->query("SELECT name, path FROM `categories`");
    $categories = $stmt->fetchAll();
    return $categories;
}

function categoriesPath($pdo)
{
    $categories = categories($pdo);
    $categoriesPath = [];
    foreach ($categories as $key => $value) {
        $categoriesPath[] = $categories[$key]['path'];
    }
    return $categoriesPath;
}

function categoryPaths($pdo)
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));
    if (($segments[0] === 'category' && isset($segments[1]) &&
        in_array($segments[1], categoriesPath($pdo)))) {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}

function newCategoryPaths($pdo)
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));
    if (
        $segments[0] === 'new' && isset($segments[1]) && $segments[1] === 'category' &&
        isset($segments[2]) && in_array($segments[2], categoriesPath($pdo))
    ) {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}

function saleCategoryPaths($pdo)
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));
    if (
        $segments[0] === 'sale' && isset($segments[1]) && $segments[1] === 'category' &&
        isset($segments[2]) && in_array($segments[2], categoriesPath($pdo))
    ) {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}

function isActiveTitle($menu)
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));
    $arr = [];
    foreach ($menu as $key => $value) {
        $segmentsPath = explode('/', trim($value['path'], '/'));
        $arr[$key]['title'] = $value['title'];
        $arr[$key]['path'] = $value['path'];
        $arr[$key]['style'] = '';
        if ($segments[0] !== 'admin' && $segments[0] === $segmentsPath[0]) {
            $arr[$key]['style'] = 'active';
        }
        if ($segments[0] === 'category' && $segmentsPath[0] === '') {
            $arr[$key]['style'] = 'active';
        }
        if (
            $segments[0] === 'admin' &&
            (!empty($segments[1]) && !empty($segmentsPath[1])) &&
            $segments[1] === $segmentsPath[1]
        ) {
            $arr[$key]['style'] = 'active';
        }
    }
    return $arr;
}

function isActiveCategory($menu, $categories)
{
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));
    $segment = array_pop($segments);
    $arr = [];
    foreach ($categories as $key => $value) {
        $arr[$key]['name'] = $value['name'];
        $arr[$key]['path'] = $value['path'];
        if ($value['path'] === $segment) {
            $arr[$key]['style'] = 'active';
        }
    }
    return $arr;
}

function options($pdo, $quantityInPage, $minPrice, $maxPrice, $filterId = '')
{
    $minFilterId = 3;
    $maxFilterId = 3;
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $segments = explode('/', trim($uri, '/'));
    $category = 'all';
    if (
        $segments[0] === 'new' && isset($segments[1]) && $segments[1] === 'category' &&
        isset($segments[2]) && in_array($segments[2], categoriesPath($pdo))
    ) {
        $category = $segments[2];
    }
    if (
        $segments[0] === 'sale' && isset($segments[1]) && $segments[1] === 'category' &&
        isset($segments[2]) && in_array($segments[2], categoriesPath($pdo))
    ) {
        $category = $segments[2];
    }
    if (($segments[0] === 'category' && isset($segments[1]) &&
        in_array($segments[1], categoriesPath($pdo)))) {
        $category = $segments[1];
    }
    if (
        isset($_GET['min-price']) && !empty($_GET['min-price']) &&
        isset($_GET['max-price']) && !empty($_GET['max-price'])
    ) {
        $minPrice = (int)$_GET['min-price'];
        $maxPrice = (int)$_GET['max-price'];
    }
    if (isset($_GET['new']) && !empty($_GET['new']) && isset($_GET['sale']) && !empty($_GET['sale'])) {
        $new = $_GET['new'];
        $minFilterId = 1;
        $maxFilterId = 2;
    }
    if (isset($_GET['new']) && !empty($_GET['new'])) {
        $new = $_GET['new'];
        $minFilterId = 1;
        $maxFilterId = 1;
    }
    if (isset($_GET['sale']) && !empty($_GET['sale'])) {
        $sale = $_GET['sale'];
        $minFilterId = 2;
        $maxFilterId = 2;
    }
    if (
        isset($_GET['sale']) && !empty($_GET['sale']) &&
        isset($_GET['new']) && !empty($_GET['new'])
    ) {
        $sale = $_GET['sale'];
        $minFilterId = 1;
        $maxFilterId = 2;
    }
    if ($filterId) {
        $stmt = $pdo->prepare("SELECT
        COUNT(p.name)
        FROM `products` p 
        JOIN `products_filters` pf ON pf.product_id = p.id
        JOIN `categories_products` cp ON cp.product_id = p.id
        JOIN `categories` c ON cp.category_id = c.id
        WHERE c.path = ? AND pf.filter_id = ? AND p.price BETWEEN ? AND ? AND is_deleted = 0");
        $stmt->execute(array($category, $filterId, $minPrice, $maxPrice));
    } elseif ($minFilterId === 1 && $maxFilterId === 2 && !$filterId) {
        $stmt = $pdo->prepare("SELECT	
        COUNT(p.name)
        FROM `products` p
        WHERE id IN (SELECT
        p.id
        FROM `products` p 
        JOIN `products_filters` pf ON pf.product_id = p.id
        JOIN `categories_products` cp ON cp.product_id = p.id
        JOIN `categories` c ON cp.category_id = c.id
        WHERE c.path = ? AND pf.filter_id IN(?,?) AND p.price BETWEEN ? AND ? AND is_deleted = 0
        GROUP BY p.id HAVING COUNT(*) > 1) ");
        $stmt->execute(array($category, $minFilterId, $maxFilterId, $minPrice, $maxPrice));
    } elseif ($minFilterId !== 1 || $maxFilterId !== 2 && !$filterId) {
        $stmt = $pdo->prepare("SELECT
        COUNT(p.name)
        FROM `products` p 
        JOIN `products_filters` pf ON pf.product_id = p.id
        JOIN `categories_products` cp ON cp.product_id = p.id
        JOIN `categories` c ON cp.category_id = c.id
        WHERE c.path = ? AND pf.filter_id IN(?,?) AND p.price BETWEEN ? AND ? AND is_deleted = 0");
        $stmt->execute(array($category, $minFilterId, $maxFilterId, $minPrice, $maxPrice));
    }
    $count = $stmt->fetch();
    $count = $count['COUNT(p.name)'];
    $total = intval(($count - 1) / $quantityInPage) + 1;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $page = intval($page);
    if (empty($page) or $page < 0) $page = 1;
    if ($page > $total) $page = $total;
    $start = $page * $quantityInPage - $quantityInPage;
    $options = [
        'category' => $category,
        'min_filter_id' => $minFilterId,
        'max_filter_id' => $maxFilterId,
        'min_price' => $minPrice,
        'max_price' => $maxPrice,
        'count' => $count,
        'total' => $total,
        'start' => $start,
        'quantity_in_page' => $quantityInPage
    ];
    return $options;
}


function productFilter($pdo, $options, $filterId = '')
{
    $sortCategory = 'price';
    $sortPrices = 'asc';
    if (isset($_GET['category']) && ($_GET['category'] === 'price' || $_GET['category'] === 'name')) {
        $sortCategory = $_GET['category'];
    }
    if (isset($_GET['prices']) && ($_GET['prices'] === 'asc' || $_GET['prices'] === 'desc')) {
        $sortPrices = $_GET['prices'];
    }
    if ($filterId) {
        $stmt = $pdo->prepare("SELECT
        p.id,
        p.image,
        p.price as price,
        p.name as name
        FROM `products` p 
        JOIN `products_filters` pf ON pf.product_id = p.id
        JOIN `categories_products` cp ON cp.product_id = p.id
        JOIN `categories` as c ON cp.category_id = c.id
        WHERE c.path = ? AND pf.filter_id = ? AND price BETWEEN ? AND ? AND is_deleted = 0
        ORDER BY {$sortCategory} {$sortPrices} 
        LIMIT ?, ?");
        $stmt->execute(array(
            $options['category'], $filterId,
            $options['min_price'], $options['max_price'],
            $options['start'], $options['quantity_in_page']
        ));
        $products = $stmt->fetchAll();
    } elseif ($options['min_filter_id'] === 1 && $options['max_filter_id'] === 2 && !$filterId) {
        $stmt = $pdo->prepare("SELECT
        p.id,
        p.image,
        p.price as price,
        p.name as name
        FROM `products` p 
        JOIN `products_filters` pf ON pf.product_id = p.id
        JOIN `categories_products` cp ON cp.product_id = p.id
        JOIN `categories` as c ON cp.category_id = c.id
        WHERE c.path = ? AND pf.filter_id IN(?, ?) AND price BETWEEN ? AND ? AND is_deleted = 0
        GROUP BY p.id HAVING COUNT(*) > 1
        ORDER BY {$sortCategory} {$sortPrices} 
        LIMIT ?, ?");
        $stmt->execute(array(
            $options['category'], $options['min_filter_id'], $options['max_filter_id'],
            $options['min_price'], $options['max_price'],
            $options['start'], $options['quantity_in_page']
        ));
        $products = $stmt->fetchAll();
    } elseif ($options['min_filter_id'] !== 1 || $options['max_filter_id'] !== 2 && !$filterId) {
        $stmt = $pdo->prepare("SELECT
        p.id,
        p.image,
        p.price as price,
        p.name as name
        FROM `products` p 
        JOIN `products_filters` pf ON pf.product_id = p.id
        JOIN `categories_products` cp ON cp.product_id = p.id
        JOIN `categories` as c ON cp.category_id = c.id
        WHERE c.path = ? AND pf.filter_id IN(?, ?) AND price BETWEEN ? AND ? AND is_deleted = 0
        ORDER BY {$sortCategory} {$sortPrices} 
        LIMIT ?, ?");
        $stmt->execute(array(
            $options['category'], $options['min_filter_id'], $options['max_filter_id'],
            $options['min_price'], $options['max_price'],
            $options['start'], $options['quantity_in_page']
        ));
        $products = $stmt->fetchAll();
    }
    return $products;
}

function path()
{
    $minPrice = '';
    $maxPrice = '';
    $new = '';
    $sale = '';
    $category = '';
    $price = '';

    if (isset($_GET['min-price']) || isset($_GET['new']) || isset($_GET['sale'])) {
        $page = '&page=';
    } else {
        $page = 'page=';
    }
    if (isset($_GET['min-price'])) {
        $minPrice = 'min-price=' . $_GET['min-price'];
    }
    if (isset($_GET['max-price'])) {
        $maxPrice = '&max-price=' . $_GET['max-price'];
    }
    if (!empty($_GET['new'])) {
        $new = '&new=' . $_GET['new'];
    }
    if (!empty($_GET['sale'])) {
        $sale = '&sale=' . $_GET['sale'];
    }
    if (!empty($_GET['category'])) {
        $category = '&category=' . $_GET['category'];
    }
    if (!empty($_GET['prices'])) {
        $price = '&prices=' . $_GET['prices'];
    }
    return $minPrice . $maxPrice . $new . $sale . $category . $price . $page;
}

function minBasePrice($pdo)
{
    $stmt = $pdo->query("SELECT 
    min(price)  AS min_base_price FROM `products`");
    $minPrice = $stmt->fetch();
    return $minPrice['min_base_price'];
}

function maxBasePrice($pdo)
{
    $stmt = $pdo->query("SELECT 
    max(price)  AS max_base_price FROM `products`");
    $minPrice = $stmt->fetch();
    return $minPrice['max_base_price'];
}

function minPrice($minPrice)
{
    if (isset($_GET['min-price']) && !empty($_GET['min-price'])) {
        $minPrice = intval($_GET['min-price']);
    }
    return $minPrice;
}

function maxPrice($maxPrice)
{
    if (isset($_GET['max-price']) && !empty($_GET['max-price'])) {
        $maxPrice = intval($_GET['max-price']);
    }
    return $maxPrice;
}

function dataOrder($pdo, $order)
{
    $arr = [];
    if ($_POST['delivery'] === 'dev-no') {
        $stmt = $pdo->prepare("SELECT 
        d.id AS delivery_id,
        pm.id AS payment_method_id,
        p.price
        FROM `deliveries` AS d 
        JOIN `payment_methods` AS pm
        JOIN `products` AS p
        WHERE d.name = ? AND pm.name = ? AND p.id = ?");
        $stmt->execute(array($order['delivery'], $order['pay'], $order['product_id']));
        $items = $stmt->fetchAll();
        $data = [];
        foreach ($items[0] as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }
    if ($_POST['delivery'] === 'dev-yes') {
        $show = showSetting($pdo, $_POST['delivery_method_id']);
        $stmt = $pdo->prepare("SELECT 
        d.id AS delivery_id,
        pm.id AS payment_method_id,
        p.price + ? AS price
        FROM `deliveries` AS d 
        JOIN `payment_methods` AS pm
        JOIN `products` AS p
        WHERE d.name = ? AND pm.name = ? AND p.id = ?");
        $stmt->execute(array($show['delivery_price'], $order['delivery'], $order['pay'], $order['product_id']));
        $items = $stmt->fetchAll();
        $data = [];
        foreach ($items[0] as $key => $value) {
            $data[$key] = $value;
        }
        return $data;
    }
}

function insertOrder($pdo, $dataOrder)
{
    $paymentStatus = 0;
    $status = 0;
    $sql = "INSERT INTO `orders` (product_id, delivery_id, delivery_method_id, payment_status, status, name, surname, 
    phone, thirdName, email, city, comment, street, home, aprt, payment_method_id, price) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $isAddress = isAddress($pdo);
    if ($dataOrder['delivery_id'] === 2 && $isAddress) {
        $pdo->prepare($sql)->execute([
            $_POST['product_id'],  $dataOrder['delivery_id'], $_POST['delivery_method_id'],
            $paymentStatus, $status, $_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['thirdName'],
            $_POST['email'], $_POST['city'], $_POST['comment'], $_POST['street'], $_POST['home'], $_POST['aprt'],
            $dataOrder['payment_method_id'], $dataOrder['price']
        ]);
    }
    if ($dataOrder['delivery_id'] === 2 && !$isAddress) {
        $pdo->prepare($sql)->execute([
            $_POST['product_id'],  $dataOrder['delivery_id'], $_POST['delivery_method_id'],
            $paymentStatus, $status, $_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['thirdName'],
            $_POST['email'], $_POST['city'], $_POST['comment'], $_POST['street'], $_POST['home'], $_POST['aprt'],
            $dataOrder['payment_method_id'], $dataOrder['price']
        ]);
    }
    if ($dataOrder['delivery_id'] === 1) {
        $pdo->prepare($sql)->execute([
            $_POST['product_id'],  $dataOrder['delivery_id'],  4,
            $paymentStatus, $status, $_POST['name'], $_POST['surname'], $_POST['phone'], $_POST['thirdName'],
            $_POST['email'], '', $_POST['comment'], '', '', '',
            $dataOrder['payment_method_id'], $dataOrder['price']
        ]);
    }
}

function isAddress($pdo)
{
    if (isset($_POST['city']) && isset($_POST['street'])) {
        $stmt = $pdo->prepare("SELECT
        city FROM `addresses` 
        WHERE city LIKE ? AND street LIKE ?");
        $stmt->execute(array($_POST['city'], $_POST['street'] . '%'));
        $address = $stmt->fetch();
        if (!empty($address)) {
            return true;
        }
    }
    return false;
}

function checkAddress($pdo)
{
    if (isset($_POST['city']) && isset($_POST['street'])) {
        $stmt = $pdo->prepare("SELECT
        city FROM `addresses` 
        WHERE city LIKE ? AND street LIKE ?");
        $stmt->execute(array($_POST['city'], $_POST['street']));
        $address = $stmt->fetch();
        if (!empty($address)) {
            return true;
        }
    }
    return false;
}

function addresses($pdo, $street)
{
    $stmt = $pdo->prepare("SELECT
    street FROM `addresses` 
    WHERE street LIKE ?");
    $stmt->execute(array($street . '%'));
    $addresses = $stmt->fetchAll();
    $streets = [];
    foreach ($addresses as $value) {
        $streets[] = $value['street'];
    }
    return $streets;
}

function mainMenu($pdo, $menu, $login = [])
{
    $userStatus = userStatus($pdo, $login);
    $arr = [];
    foreach ($menu as $key => $value) {
        if ($userStatus >= $value['user_status']) {
            $arr[$key] = $menu[$key];
        }
    }
    return $arr;
}

function userStatus($pdo, $login = [])
{
    if (!empty($login)) {
        $stmt = $pdo->prepare("SELECT 
        max(gu.group_id) as status
        FROM `groups_users` gu
        JOIN `users` u ON gu.user_id = u.id
        WHERE u.email = ?");
        $stmt->execute(array($login));
        $status = $stmt->fetch();
        $userStatus = $status['status'];
    } else {
        $userStatus = 1;
    }
    return $userStatus;
}

function ordersList($pdo)
{
    $stmt = $pdo->query("SELECT 
    o.id as id, 
    o.created_at,
    o.name,
    o.price, 
    o.surname, 
    o.thirdName, 
    o.phone,
    o.status,
    o.city,
    o.street,
    o.aprt,
    o.comment,
    d.description as delivery,
    pm.description as payment_method
    FROM `orders` o
    JOIN `deliveries` d ON o.delivery_id = d.id
    JOIN `payment_methods` pm ON o.payment_method_id = pm.id
    ORDER BY status ASC, id DESC");
    $orderList = $stmt->fetchAll();
    $list = [];
    foreach ($orderList as $key => $value) {
        $list[$key] = $value;
        if ($value['status'] === 0) {
            $list[$key]['status_name'] = 'Не выполнено';
            $list[$key]['status_style'] = 'order-item__info--no';
        } else {
            $list[$key]['status_name'] = 'Выполнено';
            $list[$key]['status_style'] = 'order-item__info--yes';
        }
    }
    return $list;
}

function productPaginator($pdo, $quantityInPage)
{
    $stmt = $pdo->query("SELECT
    COUNT(id) as count
    FROM `products` WHERE is_deleted = 0");
    $items = $stmt->fetch();
    $count = $items['count'];
    $total = intval(($count - 1) / $quantityInPage) + 1;
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $page = intval($page);
    if (empty($page) or $page < 0) $page = 1;
    if ($page > $total) $page = $total;
    $start = $page * $quantityInPage - $quantityInPage;
    $options = [
        'count' => $count,
        'total' => $total,
        'start' => $start,
        'quantity_in_page' => $quantityInPage
    ];
    return $options;
}


function productsList($pdo, $options)
{
    $stmt = $pdo->prepare("SELECT
    p.id as id,
    p.name as name,
    p.price as price,
    GROUP_CONCAT(DISTINCT c.name SEPARATOR ',') as category,
    GROUP_CONCAT(DISTINCT f.name SEPARATOR ',') as filter
    FROM `products` p
    JOIN `categories_products` cp ON cp.product_id = p.id
    JOIN `categories` c ON cp.category_id = c.id
    JOIN `products_filters` pf ON pf.product_id = p.id
    JOIN `filters` f ON pf.filter_id = f.id
    WHERE is_deleted = 0
    GROUP BY id 
    ORDER BY id DESC
    LIMIT ?, ?");
    $stmt->execute(array($options['start'], $options['quantity_in_page']));
    $productsList = $stmt->fetchAll();
    return $productsList;
}

/**
 * Функция возвращает строку с разрешенными типами файлов
 * @param array $validMimeTypes массив с миме типами файлов
 * @return string $validNames строку с типами файлов
 */
function createValidTypes($validMimeTypes): string
{
    $validTypes = [];
    foreach ($validMimeTypes as $value) {
        $validTypes[] = substr($value, 6);
    }
    $validNames = implode(", ", $validTypes) . '.';
    return $validNames;
}

function insertInProducts($pdo, $imageName)
{
    $sql = "INSERT INTO `products` (name, image, price) 
    VALUES (?,?,?)";
    $pdo->prepare($sql)->execute([$_POST['name'],  $imageName, $_POST['price']]);
}

function selectProductId($pdo)
{
    $stmt = $pdo->prepare("SELECT
    id FROM `products` 
    WHERE name = ?");
    $stmt->execute(array($_POST['name']));
    $product = $stmt->fetch();
    return $product['id'];
}

function insertInProductsFilters($pdo)
{
    $new = 0;
    $sale = 0;
    if ($_POST['new'] === 'on') {
        $new = 1;
    }
    if ($_POST['sale'] === 'on') {
        $sale = 2;
    }
    $stmt = $pdo->prepare("SELECT
    GROUP_CONCAT(DISTINCT f.id SEPARATOR ',') as filters_id, 
    p.id as product_id
    FROM `filters` f
    JOIN `products` p
    WHERE f.id IN(?,?) and p.name = ?");
    $stmt->execute(array($new, $sale, $_POST['name']));
    $filtersList = $stmt->fetchAll();
    $filtersId = explode(',', $filtersList[0]['filters_id']);
    foreach ($filtersId as $filterId) {
        $sql = "INSERT INTO `products_filters` (product_id, filter_id) 
        VALUES (?,?)";
        if ($filterId) {
            $pdo->prepare($sql)->execute([$filtersList[0]['product_id'], $filterId]);
        } else {
            $pdo->prepare($sql)->execute([$filtersList[0]['product_id'], 3]);
        }
    }
}

function insertInCategoriesProducts($pdo, $productId)
{
    $categoryName = explode(',', $_POST['category']);
    $in  = str_repeat('?,', count($categoryName) - 1) . '?';
    $sql = "SELECT
    GROUP_CONCAT(DISTINCT id SEPARATOR ',') as categories_id 
    FROM `categories`
    WHERE path IN ($in)";
    $stm = $pdo->prepare($sql);
    $stm->execute($categoryName);
    $data = $stm->fetchAll();
    $addCategoriesId = explode(',', $data[0]['categories_id']);
    array_push($addCategoriesId, '5');
    foreach ($addCategoriesId as $categoryId) {
        $sql = "INSERT INTO `categories_products` (category_id, product_id) 
        VALUES (?,?)";
        $pdo->prepare($sql)->execute([$categoryId,  $productId]);
    }
}

function selectProductsNames($pdo)
{
    $stmt = $pdo->query("SELECT name FROM `products`");
    $products = $stmt->fetchAll();
    $productNames = [];
    foreach ($products as $productName) {
        $productNames[] = $productName['name'];
    }
    return $productNames;
}

function checkPrice()
{
    $postNumber = $_POST['price'];
    $segments = explode(".", $postNumber);
    $checkSegment = (string)((int)$segments[0]);
    if (isset($checkSegment) && is_numeric($postNumber) && $segments[0] === $checkSegment) {
        return true;
    } else {
        return false;
    }
}

function checkNumber($postNumber)
{
    $segments = explode(".", $postNumber);
    $checkSegment = (string)((int)$segments[0]);
    if (isset($checkSegment) && is_numeric($postNumber) && $segments[0] === $checkSegment) {
        return true;
    } else {
        return false;
    }
}

function softDeleteProduct($pdo)
{
    $stmt = $pdo->prepare("UPDATE `products`
    SET is_deleted = 1
    WHERE id = ?");
    $stmt->execute(array($_POST['product_id']));
}

function selectProductById($pdo)
{
    $stmt = $pdo->prepare("SELECT
    p.id,
    p.name as name,
    p.image as image,
    p.price as price,
    GROUP_CONCAT(DISTINCT c.name SEPARATOR ',') as category,
    GROUP_CONCAT(DISTINCT f.name SEPARATOR ',') as filter
    FROM `products` p
    JOIN `categories_products` cp ON cp.product_id = p.id
    JOIN `categories` c ON cp.category_id = c.id
    JOIN `products_filters` pf ON pf.product_id = p.id
    JOIN `filters` f ON pf.filter_id = f.id
    WHERE p.id = ?");
    $stmt->execute(array($_GET['id']));
    $product = $stmt->fetchAll();
    return $product[0];
}

function updateProductFile($pdo, $fileName)
{
    $stmt = $pdo->prepare("UPDATE `products`
    SET name = ?, image = ?, price = ?
    WHERE id = ?");
    $stmt->execute(array($_POST['name'], $fileName, $_POST['price'], $_POST['id']));
    $product = $stmt->fetchAll();
}

function updateProduct($pdo)
{
    $stmt = $pdo->prepare("UPDATE `products`
    SET name = ?, price = ?
    WHERE id = ?");
    $stmt->execute(array($_POST['name'], $_POST['price'], $_POST['id']));
    $product = $stmt->fetchAll();
}

function isName($pdo)
{
    $stmt = $pdo->prepare("SELECT
    name FROM `products` WHERE id != ?");
    $stmt->execute(array($_POST['id']));
    $products = $stmt->fetchAll();
    $productsNames  = [];
    foreach ($products as $value) {
        $productsNames[] = $value['name'];
    }
    return in_array($_POST["name"], $productsNames);
}

function inDataBaseCategoriesId($pdo)
{
    $stmt = $pdo->prepare("SELECT
    category_id FROM `categories_products` WHERE product_id = ?");
    $stmt->execute(array($_POST['id']));
    $categories = $stmt->fetchAll();
    $categoriesId = [];
    foreach ($categories as $value) {
        $categoriesId[] = $value['category_id'];
    }
    return $categoriesId;
}

function postCategoriesId($pdo)
{
    $postCategory = explode(",", $_POST['category']);
    $arr = [];
    foreach ($postCategory as $value) {
        $arr[] = "path = ?";
    }
    $position = implode(" OR ", $arr);

    $stmt = $pdo->prepare("SELECT
    id FROM `categories` WHERE $position");
    $stmt->execute($postCategory);
    $categories = $stmt->fetchAll();
    $categoriesId = [];
    foreach ($categories as $category) {
        $categoriesId[] = $category['id'];
    }
    return $categoriesId;
}

function insertInCategoryProductOptions($pdo)
{
    $categoriesIdInDataBase = inDataBaseCategoriesId($pdo);
    $postCategoriesId = postCategoriesId($pdo);
    $categoriesIdValues = [];
    foreach ($postCategoriesId as $value) {
        if (!in_array($value, $categoriesIdInDataBase)) {
            $categoriesIdValues[] = $value;
        }
    }
    return $categoriesIdValues;
}

function insertInCategoriesProduct($pdo)
{
    $insertOptions = insertInCategoryProductOptions($pdo);
    if (!empty($insertOptions)) {
        foreach ($insertOptions as $categoryId) {
            $sql = "INSERT INTO `categories_products` (category_id, product_id) 
            VALUES (?,?)";
            $pdo->prepare($sql)->execute([$categoryId,  $_POST['id']]);
        }
    }
}

function deleteInCategoryProductOptions($pdo)
{
    $categoriesIdInDataBase = inDataBaseCategoriesId($pdo);
    $postCategoriesId = postCategoriesId($pdo);
    $deleteIdValues = [];
    foreach ($categoriesIdInDataBase as $value) {
        if (!in_array($value, $postCategoriesId) && $value !== 5) {
            $deleteIdValues[] = $value;
        }
    }
    return $deleteIdValues;
}

function deleteInCategoriesProduct($pdo)
{
    $deleteOptions = deleteInCategoryProductOptions($pdo);
    if (!empty($deleteOptions)) {
        foreach ($deleteOptions as $categoryId) {
            $sql = "DELETE FROM `categories_products`
            WHERE category_id = ? AND product_id = ?";
            $pdo->prepare($sql)->execute([$categoryId,  $_POST['id']]);
        }
    }
}

function postFilterValues()
{
    $arr = [];
    if (!empty($_POST['new'])) {
        $arr[] = 1;
    }
    if (!empty($_POST['sale'])) {
        $arr[] = 2;
    }
    return $arr;
}

function dataBaseFilterValues($pdo)
{
    $stmt = $pdo->prepare("SELECT
    filter_id FROM `products_filters` WHERE product_id = ?");
    $stmt->execute(array($_POST['id']));
    $filters = $stmt->fetchAll();
    $filtersId = [];
    foreach ($filters as $value) {
        if ($value['filter_id'] !== 3) {
            $filtersId[] = $value['filter_id'];
        }
    }
    return $filtersId;
}

function deleteInProductsFiltersOptions($pdo)
{
    $dataBaseFilterValues = dataBaseFilterValues($pdo);
    $postFilterValues = postFilterValues();
    $deleteIdValues = [];
    foreach ($dataBaseFilterValues as $value) {
        if (!in_array($value, $postFilterValues) && $value !== 3) {
            $deleteIdValues[] = $value;
        }
    }
    return $deleteIdValues;
}

function deleteInProductsFilters($pdo)
{
    $deleteOptions = deleteInProductsFiltersOptions($pdo);
    if (!empty($deleteOptions)) {
        foreach ($deleteOptions as $filterId) {
            $sql = "DELETE FROM `products_filters`
            WHERE filter_id = ? AND product_id = ?";
            $pdo->prepare($sql)->execute([$filterId,  $_POST['id']]);
        }
    }
}

function insertInProductsFiltersOptions($pdo)
{
    $dataBaseFilterValues = dataBaseFilterValues($pdo);
    $postFilterValues = postFilterValues();
    $insertIdValues = [];
    foreach ($postFilterValues as $value) {
        if (!in_array($value, $dataBaseFilterValues)) {
            $insertIdValues[] = $value;
        }
    }
    return $insertIdValues;
}

function insertInProductsFiltersUpdate($pdo)
{
    $insertOptions = insertInProductsFiltersOptions($pdo);
    if (!empty($insertOptions)) {
        foreach ($insertOptions as $filterId) {
            $sql = "INSERT INTO `products_filters` (product_id, filter_id) 
            VALUES (?,?)";
            $pdo->prepare($sql)->execute([$_POST['id'], $filterId]);
        }
    }
}

function showSetting($pdo, $deliveryMethodsId = 1)
{
    $stmt = $pdo->prepare("SELECT
    dc.order_sum,
    dc.delivery_price
    FROM `delivery_customizations` dc
    JOIN  `delivery_methods` dm ON dc.delivery_method_id = dm.id
    WHERE dm.id = ? AND dc.created_at = (SELECT
    	max(dc.created_at)
        FROM `delivery_customizations` dc
    	JOIN  `delivery_methods` dm ON dc.delivery_method_id = dm.id
   		WHERE dm.id = ?)");
    $stmt->execute(array($deliveryMethodsId, $deliveryMethodsId));
    $settings = $stmt->fetchAll();
    return $settings[0];
}

function showDeliveryPrices($pdo)
{
    $stmt = $pdo->query("SELECT
    dc.delivery_method_id,
    dc.delivery_price,
    max(dc.created_at) as created_at,
    dm.description
    FROM `delivery_customizations` dc
    JOIN `delivery_methods` dm ON dc.delivery_method_id = dm.id
    WHERE dm.id = 1 AND dc.created_at = (SELECT
    	max(dc.created_at)
        FROM `delivery_customizations` dc
    	JOIN  `delivery_methods` dm ON dc.delivery_method_id = dm.id
   		WHERE dm.id = 1)
           GROUP BY dc.delivery_price
    UNION ALL
SELECT
    dc.delivery_method_id,
    dc.delivery_price,
    max(dc.created_at) as created_at,
    dm.description
    FROM `delivery_customizations` dc
    JOIN `delivery_methods` dm ON dc.delivery_method_id = dm.id
    WHERE dm.id = 2 AND dc.created_at = (SELECT
    	max(dc.created_at)
        FROM `delivery_customizations` dc
    	JOIN  `delivery_methods` dm ON dc.delivery_method_id = dm.id
   		WHERE dm.id = 2)
           GROUP BY dc.delivery_price
    UNION ALL
SELECT
    dc.delivery_method_id,
    dc.delivery_price,
    max(dc.created_at) as created_at,
    dm.description
    FROM `delivery_customizations` dc
    JOIN `delivery_methods` dm ON dc.delivery_method_id = dm.id
    WHERE dm.id = 3 AND dc.created_at = (SELECT
    	max(dc.created_at)
        FROM `delivery_customizations` dc
    	JOIN  `delivery_methods` dm ON dc.delivery_method_id = dm.id
   		WHERE dm.id = 3)
           GROUP BY dc.delivery_price");
    $settings = $stmt->fetchAll();
    return $settings;
}

function insertDeliveryCustomizations($pdo)
{
    $_POST['delivery_value'];
    $sql = "INSERT INTO `delivery_customizations` (delivery_id, delivery_method_id, order_sum, delivery_price) 
    VALUES (?,?,?,?)";
    $pdo->prepare($sql)->execute([2,  $_POST['delivery_value'], $_POST['order_sum'], $_POST['delivery_price']]);
}

function showDelivery($pdo, $deliveryMethod)
{
    $stmt = $pdo->prepare("SELECT
    dc.order_sum,
    dc.delivery_price
    FROM `delivery_customizations` dc
    JOIN  `delivery_methods` dm ON dc.delivery_method_id = dm.id
    WHERE dm.description = ? AND dc.created_at = (SELECT
    	max(dc.created_at)
        FROM `delivery_customizations` dc
    	JOIN  `delivery_methods` dm ON dc.delivery_method_id = dm.id
   		WHERE dm.description = ?)");
    $stmt->execute(array($deliveryMethod, $deliveryMethod));
    $settings = $stmt->fetchAll();
    return $settings[0];
}

<?php

ini_set('session.name', 'session_id');
session_start([
    'cookie_lifetime' => 0,
]);

if (isset ($_COOKIE['login']) && isset ($_SESSION['login'])) {
	setcookie('login', $_COOKIE['login'], time() + 60 * 60 * 24 * 30, '/');
}

if(isset ($_GET['logout']) && $_GET['logout'] === 'yes') {
	unset($_SESSION['login']);
}

// phpinfo();

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/main-menu.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/admin/authorization.php';

if ($isAuth) {
	$userStatus = userStatus($pdo, $_SESSION['login']);
	if ($userStatus === 1) {
		header("Location: /");
	} elseif ($userStatus === 2) {
		header("Location: /admin/orders");
	} elseif ($userStatus === 3) {
		header("Location: /admin/products/");
	}
}

require $_SERVER['DOCUMENT_ROOT'] . '/templates/header.php';
require $_SERVER['DOCUMENT_ROOT'] . showContent($menu);
require $_SERVER['DOCUMENT_ROOT'] . '/templates/footer.php';

$pdo = null;
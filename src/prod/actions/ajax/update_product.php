<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';

$success = '';
$errors = [];
$maxImageSize	= 5 * 1024 * 1024;
$path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'; 
$validMimeTypes = ["image/jpg", "image/png", "image/jpeg"];
$validTypes = createValidTypes($validMimeTypes);
$productsNames = selectProductsNames($pdo);
$checkPrice = checkPrice();

if (isset($_FILES['file']['tmp_name'])) {
	$file = $_FILES['file'];
	$fileSize = $file['size'];
	$tmpFileName = $file['tmp_name'];
	if ($fileSize > $maxImageSize) {
    	array_push ($errors, 'Размер файла не больше 5MB.');
	}
	if (! in_array(mime_content_type($tmpFileName), $validMimeTypes)) {
    	array_push ($errors, 'Типы файла только: ' . $validTypes);
	}
} 

if (isset($_POST['file']) && $_POST['default_image_name'] === 'undefined') {
	array_push ($errors, 'Вы не выбрали файл.');
}

if (!empty ($_POST["category"]) && $_POST["category"] === 'null') {
	array_push ($errors, 'Введите категорию товара.');
}
if (empty ($_POST["name"])) {
	array_push ($errors, 'Введите название товара.');
}
if (!empty ($_POST["name"]) && isName($pdo)) {
	array_push ($errors, 'Такое название товара уже существует в базе данных.');
}
if (empty ($_POST['price'])) {
	array_push ($errors, 'Введите цену товара.');
}
if (!empty ($_POST['price']) && !$checkPrice) {
	array_push ($errors,'Цена товара должна быть десятичным числом.');
}

if (count($errors) === 0 && isset($_POST['category'])) {
	if ($_POST['default_image_name'] === 'undefined') {
		$path_parts = pathinfo($_FILES['file']['name']);
		$ext = $path_parts['extension'];
		$fileName = $file['name'];
		$fileName = stristr(str_replace('%', '', rawurlencode($fileName)), '.', true);
		move_uploaded_file($file['tmp_name'], $path . $fileName . '.' . $ext);
		$fileName = 'uploads/' . $fileName . '.' .$ext;
		updateProductFile($pdo, $fileName);
	} else {
		updateProduct($pdo);
	}
	deleteInCategoriesProduct($pdo);
	insertInCategoriesProduct($pdo);
	deleteInProductsFilters($pdo);
	insertInProductsFiltersUpdate($pdo);
	$success = 'success';
}

$data = array(
	'errors'   => $errors,
	'success' => $success,
);
 
echo json_encode($data);
exit();
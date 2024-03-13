<?php

require $_SERVER['DOCUMENT_ROOT'] . '/actions/functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '/actions/connect.php';

$query = '';
if (isset($_POST['street'])) {
  $addresses = addresses($pdo, $_POST['street']);
  $query = $_POST['street'];
}

if ($query !== "") {
  $query = mb_strtolower($query);
  $len = mb_strlen($query);
  $streets = [];
  foreach($addresses as $name) {
    if (!stristr($query, mb_substr($name, 0, $len))) {
      $streets[] = $name;
    }
  }
}

echo empty($streets) ? json_encode("нет совпадений") : json_encode($streets);
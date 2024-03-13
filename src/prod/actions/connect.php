<?php

require $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';

$pdo = getConnection(HOST, DB, USER, PASSWORD, CHARSET);

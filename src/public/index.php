<?php

declare(strict_types=1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define("APP_PATH", $root . "app" . DIRECTORY_SEPARATOR);
define("VIEWS_PATH", $root . "views" . DIRECTORY_SEPARATOR);
define("FILES_PATH", $root . "transactions_file" . DIRECTORY_SEPARATOR);

require APP_PATH . 'App.php';
require APP_PATH . 'helpers.php';


$files = getFiles(FILES_PATH);

$transactions = getTransactions($files, 'formatTransaction');
$totals = calculateTotal($transactions);
require VIEWS_PATH . 'transactions.php';

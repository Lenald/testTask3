<?php
require_once 'Sorter.php';

if (empty($argv[1])) {
    die("Не правильный запуск\nПример: php ./index.php \"1 -2 -3 4 5 -6f ss3 0 0 0 -0 0.0 0.05\"\n");
}

$app = new Sorter();
$app->run($argv[1]);

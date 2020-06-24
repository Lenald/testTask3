<?php
require_once 'First.php';
require_once 'Second.php';

$first = new First();
$second = new Second();

echo "<pre>";

$first->getClassname();
$first->getLetter();

$second->getClassname();
$second->getLetter();

echo "</pre>";

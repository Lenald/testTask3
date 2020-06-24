<?php
define("ROWS", 5);
define("WORDS_PER_ROW", 5);

require_once 'StrupeTest.php';

$app = new StrupeTest();
?>
<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body {
            font-weight: bold;
            font-size: 36px;
        }
    </style>
</head>
<body>
    <?php $app->run(); ?>
</body>
</html>
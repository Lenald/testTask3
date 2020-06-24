<?php

if (!empty($_POST['team'])) {
    require_once 'lib/simplehtmldom/simple_html_dom.php';
    require_once 'Parser.php';

    $team = trim($_POST['team']);

    $parser = new Parser();
    $parser->run($team);
}

?>

<form method="post" action="index.php" style="margin: 20px">
    <input type="text" name="team" placeholder="Команда">
    <input type="submit" name="submit" value="Найти">
</form>
Скрипт работает катастрофически долго :(
Это можно исправить, если заставить его работать по принципу "находим при парсинге сезона команду, печатаем и сразу идём к другому сезону", но тогда код будет ужасным, потому что один метод будет заниматься и кучей всего. Поэтому я оставлю так. Не будем забывать об антипаттерне "преждевременная оптимизация".
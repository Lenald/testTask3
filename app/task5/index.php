<?php

use Domain\Transactions;
use Domain\DomainException;

try {
    $transactions = new Transactions();
} catch (Exception | Error $e) {
    die ("Не удалось создать экземпляр класса Transactions");
}

try {
    //Task 5.a
    //Посчитать м вывести балансы
    $balances = $transactions->getBalances();
    echo "Кошельки:
    <table border=1 style=\"margin: 20px\">
        <tr>
            <th>Имя</th>
            <th>Деньги</th>
        </tr>";
    foreach ($balances = $row) {
        echo "<tr><td>{$row['fullname']}</td><td>{$row['balance']}</td></tr>";
    }
    echo "</table>";



    //Task 5.b
    //Самый транзакционный город
    $mostTransactionedCity = $transactions->getMostTransactionedCity()
    echo "Самый транзакционный город: {$mostTransactionedCity[0]}<br>";



    //Task 5.c
    //Вывести транзакции внутри одного города
    $oneCityTransactions = $transactions->getTransacionsInsideOneCity();
    echo "Транцакции внутри одного города:
    <table border=1 style=\"margin: 20px\">
        <tr>
            <th>transaction_id</th>
            <th>from_person_id</th>
            <th>to_person_id</th>
            <th>amount</th>
        </tr>";
    foreach ($oneCityTransactions = $row) {
        echo "<tr>
            <td>{$row['transaction_id']}</td>
            <td>{$row['from_person_id']}</td>
            <td>{$row['to_person_id']}</td>
            <td>{$row['amount']}</td>
        </tr>";
    }
    echo "</table>";
} catch (DomainException $e) {
    echo "<div>{$e->getMessage}</div>";
}
<?php
namespace DAO;

class TransactionsDAO extends DAOConnection
{
    private $connection;

    public function __construct()
    {   
        try {
            $this->connection = parent::connect();
        } catch (DAOException $e) {
            die("Не удалось подключиться к базе данных. Это конец...");
        }
    }

    public function getBalances()
    {
        /* 
         * Это не моё изначальное решение. Сначала я сделал по-другому, и оно работало.
         * Я показал знакомым и спросил, как на самом деле это нужно было сделать, чтобы просто, элегантно и по красоте
         * Теперь я прошарился в coalesce. Мой изначальный вариант в комментариях в конце файла
         * Я считаю, что будет честно с моей стороны предупредить вас, что до конкретно этого решения я не сам додумался
         * Но теперь я его понимаю
         */
        $query = "
        SELECT  `fullname`,
                (
                    100
                    - COALESCE((SELECT SUM(`amount`) FROM `transactions` AS `t` WHERE `t`.`from_person_id`=`persons`.`id`), 0)
                    + COALESCE((SELECT SUM(`amount`) FROM `transactions` AS `t` WHERE `t`.`to_person_id` = `persons`.`id`), 0) 
                ) AS `balance`
            FROM `persons`
        ";
        
        try {
            $ret = $this->getRows($query);
        } catch (DAOException $e) {
            throw new DAOException("Failed to get balances", $e);
        }

        return $ret;
    }

    public function getMostTransactionedCity()
    {
        $query = "
        SELECT `cities`.`name`, COUNT(`name`) AS `ccount`
            FROM `transactions`
            INNER JOIN `persons`
                ON  `transactions`.`from_person_id`=`persons`.`id`
                    OR
                    `transactions`.`to_person_id`=`persons`.`id`
            INNER JOIN `cities`
                ON `persons`.city_id=`cities`.`id`
            GROUP BY `cities`.`name`
            ORDER BY `ccount` DESC
            LIMIT 1
        ";
        
        try {
            $ret = $this->getRow($query);
        } catch (DAOException $e) {
            throw new DAOException("Failed to get most transactioned city", $e);
        }

        return $ret;
    }

    public function getTransacionsInsideOneCity()
    {
        $query = "
        SELECT *
            FROM `transactions`
            WHERE `transaction_id` IN (
                SELECT  `transactions`.`transaction_id`
                    FROM `transactions`
                    INNER JOIN (
                        /* города отправителей */
                        SELECT `city_id` AS `from_city`, `transaction_id`
                            FROM `persons` AS `p`
                            INNER JOIN `transactions` AS `t`
                                ON `t`.`from_person_id`=`p`.`id`
                            WHERE `t`.`from_person_id`=`p`.`id`
                        ) AS `from_city_table`
                        ON `from_city_table`.`transaction_id`=`transactions`.`transaction_id`
                    INNER JOIN (
                        /* города получателей */
                        SELECT `city_id` AS `to_city`, `transaction_id`
                            FROM `persons` AS `p`
                            INNER JOIN `transactions` AS `t`
                                ON `t`.`to_person_id`=`p`.`id`
                            WHERE `t`.`to_person_id`=`p`.`id`
                        ) AS `to_city_table`
                        ON `to_city_table`.`transaction_id`=`transactions`.`transaction_id`
                    WHERE `from_city`=`to_city`
            )
        ";
        
        try {
            $ret = $this->getRows($query);
        } catch (DAOException $e) {
            throw new DAOException("Failed to get transactions inside one city", $e);
        }

        return $ret;       
    }

    private function getRow($query)
    {
        try {
            $ret = $this->connection->query($query)->fetch();
        } catch (DAOException $e) {
            throw $e;
        }

        return $ret;
    }

    private function getRows($query)
    {
        try {
            $data = $this->connection->query($query);
        } catch (DAOException $e) {
            throw $e;
        }
              
        $ret = [];
        while ($row = $data->fetch()) {
            $ret[] = $row;
        }

        return $ret;
    }
}

/*
//мой изначальный вариант основан на временной таблице

$queries['createTmpTable'] = "
CREATE TEMPORARY TABLE IF NOT EXISTS `balances`
    SELECT `id` AS `person_id`, `fullname`
    FROM `persons``
";

$queries['alterTmpTable'] = "
ALTER TABLE `balances` 
    ADD COLUMN IF NOT EXISTS `balance`
        DECIMAL(10,2) NOT NULL DEFAULT 100.00
    AFTER `fullname`
";

$queries['minusMoney'] = "
UPDATE `balances` AS b
    INNER JOIN `transactions` AS t
        ON t.`from_person_id`=b.`person_id`
    SET b.`balance` = (b.`balance` - (
        SELECT `minus`
            FROM (
                SELECT  `from_person_id`, SUM(`amount`) AS `minus`
                    FROM `transactions`, `balances`
                    WHERE `transactions`.`from_person_id`=`balances`.`person_id`
                    GROUP BY `transactions`.`from_person_id`
                ) AS tmp
                WHERE `from_person_id`=b.`person_id`
        )
    )
";

$queries['plusMoney'] = "
UPDATE `balances` AS b
    INNER JOIN `transactions` AS t
        ON t.`to_person_id`=b.`person_id`
    SET b.`balance` = (b.`balance` + (
        SELECT `plus`
            FROM (
                SELECT  `to_person_id`, SUM(`amount`) AS `plus`
                    FROM `transactions`, `balances`
                    WHERE `transactions`.`to_person_id`=`balances`.`person_id`
                    GROUP BY `transactions`.`to_person_id`
                ) AS tmp
                WHERE `to_person_id`=b.`person_id`
        )
    )
";

$db->exec($queries['createTmpTable']);  //Создаём временную таблицу
$db->exec($queries['alterTmpTable']);   //Добавляем в неё колонку
$db->exec($queries['minusMoney']);      //Отнимаем у каждого деньги, которые они кому-то заплатили
$db->exec($queries['plusMoney']);       //Прибавляем каждому деньги, которые им кто-то заплатил
$db->query('SELECT * FROM `balances`');
*/
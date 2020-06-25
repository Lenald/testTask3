<?php
namespace DAO;

class DAOConnection
{

    public function connect()
    {
        try {
            require 'dao/DBParams.php';
            return new \PDO("$driver:host=$host;dbname=$name;charset=utf8;", $user, $pass);
        } catch (\PDOException $e) {
            throw new DAOException("Failed to connect to DB", 0, $e);
        }
    }
}
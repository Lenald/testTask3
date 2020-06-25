<?php
namespace DAO;

class DAOConnection
{
    private $driver = 'mysql';
    private $host   = 'localhost';
    private $name   = 'test_Dorosh';
    private $user   = 'root';
    private $pass   = '';

    public function connect()
    {
        try {
            return new \PDO("$this->driver:host=$this->host;dbname=$this->name;charset=utf8;", $this->user, $this->pass);
        } catch (\PDOException $e) {
            global $log;
            $log->error("PDOException in ".__CLASS__."::".__METHOD__.": Failed to connect to DB", [$e->__toString()]);
            throw new DAOException("Failed to connect to DB", 0, $e);
        }
    }
}
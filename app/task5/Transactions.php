<?php
namespace Domain;

use \DAO\TransactionsDAO;
use \DAO\DAOException;

class Transactions
{
    public function getBalances()
    {
        try {
            $dao = new TransactionsDAO();
            $balances = $dao->getBalances();
        } catch (DAOException $e) {
            throw new DomainException("Не удалось получить балансы", $e);
        } finally {
            unset($dao); //чтобы не плодились подключения и дао
        }

        return $balances;
    }

    public function getMostTransactionedCity()
    {
        try {
            $dao = new TransactionsDAO();
            $mostTransactionedCity = $dao->getMostTransactionedCity();
        } catch (DAOException $e) {
            throw new DomainException("Не удалось получить самый транзакционный город", $e);
        } finally {
            unset($dao);
        }

        return $mostTransactionedCity;
    }

    public function getTransacionsInsideOneCity()
    {
        try {
            $dao = new TransactionsDAO();
            $oneCityTransactions = $dao->getTransacionsInsideOneCity();
        } catch (DAOException $e) {
            throw new DomainException("Не удалось получить транзакционние внутри одного города", $e);
        } finally {
            unset($dao);
        }

        return $oneCityTransactions;
    }
}
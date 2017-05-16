<?php

namespace AppBundle\Pagination;

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\DBAL\Driver\PDOStatement;
use Pagerfanta\Adapter\AdapterInterface;

class MySqlPdoAdapter implements AdapterInterface
{
    /** @var  PDOConnection $cn */
    private $cn;

    private $sql;

    private $sqlCount;

    private $sqlParams;

    private $items = array();

    public function __construct($cn, $sql, $sqlCount, $sqlParams = array())
    {
        $this->cn = $cn;
        $this->sql = str_replace(';', '', $sql);
        $this->sqlCount = str_replace(';', '', $sqlCount);
        $this->sqlParams = $sqlParams;
    }

    public function getNbResults()
    {
        $query = $this->cn->prepare($this->sqlCount, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
        $query->execute($this->sqlParams);
        $total = $query->fetchAll();
        return (int)$total[0][key($total[0])];
    }

    public function getSlice($offset, $length)
    {
        $sql = sprintf('%s limit %s, %s', $this->sql, $offset, $length);

        /** @var PDOStatement $query */
        $query = $this->cn->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));

        $query->execute($this->sqlParams);
        $this->items = $query->fetchAll();

        return $this->items;
    }
}
<?php

namespace AppBundle\Service;


use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManager;

class Pdo
{
    /** @var PDOConnection $pdoConnection */
    private $pdoConnection;

    public function __invoke()
    {
        return $this->getConnection();
    }

    function __construct(EntityManager $em)
    {
        $this->pdoConnection = $em->getConnection();
    }

    public function getConnection()
    {
        return $this->pdoConnection;
    }

    public function beginTransaction()
    {
        $this->pdoConnection->beginTransaction();
    }

    public function commit()
    {
        $this->pdoConnection->commit();
    }

    public function rollback()
    {
        $this->pdoConnection->rollBack();
    }

    private function _prepare($sql, $driverOptions = array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY))
    {
        return $this->pdoConnection->prepare($sql, $driverOptions);
    }

    private function _execute(Statement $query, $params)
    {
        return $query->execute($params);
    }

    private function _limitQuery($sql, $offset, $limit)
    {
        return sprintf('%s limit %s, %s', $sql, $offset, $limit);
    }

    public function execute($sql, $params = [])
    {
        /** @var Statement $query */
        $query = $this->_prepare($sql);
        $this->_execute($query, $params);
        return $query->rowCount();
    }

    public function fetchAll($sql, $params = [], $lock = '')
    {
        /** @var Statement $query */
        $query = $this->_prepare($sql . $lock);
        $this->_execute($query, $params);
        return $query->fetchAll();
    }

    public function fetchOneRow($sql, $params = [], $lock = '')
    {
        $limitedSql = $this->_limitQuery($sql, 0, 1) . $lock;

        /** @var Statement $query */
        $query = $this->_prepare($limitedSql);
        $this->_execute($query, $params);
        $rs = $query->fetchAll();

        return (count($rs) == 1) ? $rs[0] : array();
    }


    public function fetchOneField($sql, $params = [], $lock = '')
    {
        $row = $this->fetchOneRow($sql, $params, $lock);
        if (count($row) > 0)
            foreach ($row as $field)
                return $field;
        else
            return null;
    }


    public function fetchLimitQuery($sql, $params, $offset, $limit, $lock = '')
    {
        $sql = $this->_limitQuery($sql, $offset, $limit) . $lock;
        return $this->fetchAll($sql, $params);
    }


    public function showQuery($query, $params)
    {
        $keys = $values = array();

        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }

            if (is_numeric($value)) {
                $values[] = $value;
            } else {
                $values[] = sprintf('"%s"', $value);
            }
        }

        $query = preg_replace($keys, $values, $query);
        return $query;
    }


    public function insert($tableName, $params = [])
    {
        $names = $values = '';

        foreach ($params as $name => $value) {
            $names .= !empty($names) ? sprintf(',%s', $name) : $name;
            $values .= !empty($values) ? sprintf(',:%s', $value) : sprintf(':%s', $value);
        }

        if (!empty($names)) {
            $sql = sprintf('insert into %s (%s) values (%s)', $tableName, $names, $values);

            /** @var Statement $query */
            $query = $this->_prepare($sql);
            $this->_execute($query, $params);
        }
    }

    protected function tableExists($tableName)
    {
        $sql = <<<EOT
        SELECT COUNT(*) as total
        FROM information_schema.tables
        WHERE table_schema = :table_schema
        AND table_name = :table_name "
EOT;
        $params = array(
            'table_schema' => $this->pdoConnection->getDatabase(),
            'table_name' => $tableName
        );
        $rs = $this->fetchAll($sql, $params);
        return $rs[0]['total'] > 0;
    }

    protected function getPrimaryKeyName($tableName)
    {
        if (!$this->tableExists($tableName)) {
            return '';
        }

        $sql = sprintf("show index from %s where Key_name = 'PRIMARY' ", $tableName);
        $rows = $this->fetchAll($sql);
        return (count($rows) > 0) ? $rows[0]['Column_name'] : '';
    }

    public function update($tableName, $pkValue, $params, $pkName = null)
    {
        if (empty($pkName)) {
            $pkName = $this->getPrimaryKeyName($tableName);
        }

        $assignments = '';
        foreach ($params as $name => $value) {
            $assignment = sprintf('%s = :%s', $name, $name);
            $assignments .= !empty($assignments) ? sprintf(',%s', $assignment) : $assignment;
        }

        $sql = sprintf('update %s set %s where %s = %s', $tableName, $assignments, $pkName, $pkName);

        /** @var Statement $query */
        $query = $this->_prepare($sql);
        $this->_execute($query, array_merge($params, array($pkName => $pkValue)));
    }


}
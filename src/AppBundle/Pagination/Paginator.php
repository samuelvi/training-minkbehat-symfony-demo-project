<?php

namespace AppBundle\Pagination;

use Doctrine\DBAL\Driver\PDOConnection;
use Pagerfanta\Pagerfanta;
use AppBundle\Service\Pdo;

class Paginator
{
    protected $defaultMaxPerPage;
    protected $maxPerPageAllowed;

    /** @var  PDOConnection */
    protected $pdoConnection;

    /* @var Pdo $pdo */
    protected $pdo;

    public function __construct(Pdo $pdo, $defaultMaxPerPage, $maxPerPageAllowed)
    {
        $this->pdoConnection = $pdo(); // Call __invoke method
        $this->defaultMaxPerPage = $defaultMaxPerPage;
        $this->maxPerPageAllowed = $maxPerPageAllowed;
        $this->pdo = $pdo;
    }

    protected function filterMaxPerPageParameter($maxPerPage)
    {
        return ($maxPerPage <= 0 || $maxPerPage > $this->maxPerPageAllowed) ? $this->defaultMaxPerPage : $maxPerPage;
    }

    protected function filterPaginationParameters($page, $maxPerPage)
    {
        $page = (int)$page;
        $maxPerPage= $this->filterMaxPerPageParameter((int)$maxPerPage);
        return array($page, $maxPerPage);
    }

    public function getPaginatedResults( $sql, $sqlCount, $parameters, $page, $maxPerPage)
    {
        list($page, $maxPerPage) = $this->filterPaginationParameters($page, $maxPerPage);

        /** @var MySqlPdoAdapter $adapter */
        $adapter = new MySqlPdoAdapter( $this->pdoConnection, $sql, $sqlCount, $parameters);

        /** @var Pagerfanta $pagerFanta */
        $pagerFanta = new Pagerfanta($adapter);

        $pagerFanta->setMaxPerPage($maxPerPage);
        $pagerFanta->setCurrentPage($page);

        return $pagerFanta;
    }
}
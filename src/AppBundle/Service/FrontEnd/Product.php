<?php

namespace AppBundle\Service\FrontEnd;

use AppBundle\Pagination\Paginator;

class Product
{
    /** @var  Paginator $paginatorService */
    protected $paginatorService;

    public function __construct($paginatorService)
    {
        $this->paginatorService = $paginatorService;
    }

    protected function buildWhere($params)
    {
        $conditions = array();
        if (isset($params['category']) && !empty($params['category'])) {
            $conditions[] = 'category.name like :category';
        }
        if (!empty($conditions)) {
            return sprintf('where %s', join (' and ', $conditions));
        } else {
            return '';
        }
    }

    public function getPaginatedProducts($currentPage, $maxPerPage, $parameters = array())
    {
        $select =<<<EOT
            select product.id           product_id, 
                   product.name         product_name, 
                   product.description  product_description, 
                   product.price        product_price, 
                   category.name        category_name 
EOT;

        $from = 'from product left join category on product.category_id = category.id';
        $orderBy = 'order by product.created_at desc';

        $where = $this->buildWhere($parameters);

        $sql = sprintf('%s %s %s %s', $select, $from, $where, $orderBy);
        $sqlCount = sprintf('Select count(*) %s %s %s', $from, $where, $orderBy);

        return $this->paginatorService->getPaginatedResults($sql, $sqlCount, $parameters, $currentPage, $maxPerPage);
    }

}
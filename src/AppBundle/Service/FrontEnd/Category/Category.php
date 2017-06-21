<?php

namespace AppBundle\Service\FrontEnd\Category;

use AppBundle\Service\Pdo;
use APY\DataGridBundle\Grid\Grid;
use APY\DataGridBundle\Grid\GridManager;
use APY\DataGridBundle\Grid\Source\Vector;

class Category extends AbstractGridBuilder
{
    /** @var  Pdo */
    protected $pdo;

    /** @var GridManager $gridManager */
    protected $gridManager;

    public function __construct(Pdo $pdo, GridManager $gridManager)
    {
        $this->pdo = $pdo;
        $this->gridManager = $gridManager;
    }

    public function getAllCategories()
    {
<<<<<<< HEAD
        $sql = <<<SQL

=======
        $sql = '
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
                select 
                  category.id category_id, 
                  category.name category_name 
                from category 
<<<<<<< HEAD
                order by category.name
SQL;

=======
                order by category.name';
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
        return $this->pdo->fetchAll($sql);
    }

    public function getAllCategoriesGrid()
    {
        /** @var Grid $grid */
        $grid = $this->gridManager->createGrid('category_grid');

        $categories = $this->getAllCategories();
        if (count($categories) > 0) {

            $source = new Vector($categories);
            $source->setId('category_id');

            $grid->setSource($source);
            $this->setGridHeaders($grid);
            $grid->isReadyForRedirect(); // Prepare data and the grid
        }
        return $grid;
    }
}
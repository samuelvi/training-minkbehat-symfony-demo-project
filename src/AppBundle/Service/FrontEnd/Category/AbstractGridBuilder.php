<?php

namespace AppBundle\Service\FrontEnd\Category;

use APY\DataGridBundle\Grid\Column\Column;
use APY\DataGridBundle\Grid\Grid;

abstract class AbstractGridBuilder
{
    /**
     * @param Grid $grid
     */
    public function setGridHeaders(Grid &$grid)
    {
        $grid->getColumn('category_name')->setTitle('Acceso directo a Categorías');

        $cols2Hide = ['category_id'];
        $closure = function($column) use ($grid) { $grid->getColumn($column)->setVisible(false); };
        array_map($closure, $cols2Hide);

        $grid->getColumn('category_name')->setSafe(false);
        $grid->getColumn('category_name')->setAlign(Column::ALIGN_LEFT);
    }
<<<<<<< HEAD
=======


    public function getCategoriesAllGrid()
    {

    }
>>>>>>> f1e28cf3bf484eac08fc32c4bbd86d88bfdea34b
}
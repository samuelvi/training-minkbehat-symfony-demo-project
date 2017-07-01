<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Service\FrontEnd\Product as ProductService;
use AppBundle\Service\FrontEnd\Category\Category as CategoryService;

class ProductController extends Controller implements InitializableControllerInterface
{
    protected $pageVarName = 'page';

    /** @var  ProductService */
    protected $productService;

    /** @var  CategoryService $categoryService */
    protected $categoryService;

    public function __init(Request $request)
    {
        $this->productService = $this->get('app.service_front_end.product');
        $this->categoryService = $this->get('app.service_front_end_category.category');
    }

    /**
     * @Route("/products/{page}/{maxPerPage}", name="products", defaults={"page" = 1, "maxPerPage"=0})
     */
    public function indexAction(Request $request, $page, $maxPerPage)
    {
        $parameters = $this->getFilteredParameters($request);
        $products = $this->productService->getPaginatedProducts($page, $maxPerPage, $parameters);
        $categories = $this->categoryService->getAllCategoriesGrid();
        return $this->render('products/index.html.twig', array('products' => $products, 'categories' => $categories));
    }

    protected function getFilteredParameters(Request $request)
    {
        $params = array();
        $category = $request->get('category', '');
        if (!empty($category)) $params['category'] = $category;
        return $params;
    }
}
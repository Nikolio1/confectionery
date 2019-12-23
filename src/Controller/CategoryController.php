<?php

namespace App\Controller;

use App\Entity\Category;
use App\Handlers\CategoryHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 *
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @var CategoryHandler
     */
    public $categoryHandler;

    /**
     * CategoryController constructor.
     * @param CategoryHandler $categoryHandler
     */
    public function __construct(CategoryHandler $categoryHandler)
    {
        $this->categoryHandler = $categoryHandler;
    }

    /**
     * @Route("/categories", name="categories")
     *
     * @return Response
     */
    public function categories()
    {
        $categories= $this->categoryHandler
            ->getRepository(Category::class)
            ->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/category/{id}", name="show_category")
     *
     * @param Category $category
     *
     * @return Response
     */
    public function show(Category $category)
    {
        return $this->render('product/productsInCategory.html.twig', [
            'category' => $category
        ]);
    }
}

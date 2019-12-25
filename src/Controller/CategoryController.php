<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use App\Handlers\CategoryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/custom-cakes", name="custom_cakes")
     *
     *
     * @return Response
     */
    public function customCakes()
    {
        $categories= $this->categoryHandler
            ->getRepository(Category::class)
            ->findBy(
                ['isElite' => true]
            );


        return $this->render('custom_cakes/subCategories.html.twig', [
            'categories' => $categories,
        ]);
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
            ->findBy(
                ['isElite' => false]
            );

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

    /**
     * @Route("/delete-category/{id}", name="delete_category")
     *
     * @param Category $post
     *
     * @return RedirectResponse
     */
    public function delete(Category $post)
    {
        if (!$post) {
            return $this->redirectToRoute('categories');
        }
        $this->categoryHandler->removeObject($post);
        return $this->redirectToRoute('categories');
    }

    /**
     * @Route("/new-category", name="new_category")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $category= new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryHandler->saveObject($category);
            $this->addFlash('success', 'new item created success!!!');
            return $this->redirectToRoute('categories');
        }
        return $this->render('category/newCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-category/{id}", name="edit_category")
     *
     * @param Category $category
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Category $category, Request $request)
    {
        $category = $this->categoryHandler
            ->getRepository(Category::class)
            ->find($category);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryHandler->saveObject($category);
            $this->addFlash('success', 'Success)))!');
            return $this->redirectToRoute('categories');
        }
        return $this->render('category/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

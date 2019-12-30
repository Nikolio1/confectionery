<?php

namespace App\Controller;

use App\Entity\SubCategory;
use App\Form\Type\SubCategoryType;
use App\Handlers\SubCategoryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class SubCategoryController
 *
 * @package App\Controller
 */
class SubCategoryController extends AbstractController
{
    /**
     * @var SubCategoryHandler
     */
    public $subcategoryHandler;

    /**
     * CategoryController constructor.
     *
     * @param SubCategoryHandler $subcategoryHandler
     */
    public function __construct(SubCategoryHandler $subcategoryHandler)
    {
        $this->subcategoryHandler = $subcategoryHandler;
    }

    /**
     * @Route("/sub-category", name="sub_category")
     *
     * @return Response
     */
    public function index()
    {
        return $this->render('custom_cakes/subCategories.html.twig');
    }

    /**
     * @Route("/sub-category/{id}", name="show_subCategory")
     *
     * @param SubCategory $subCategory
     *
     * @return Response
     */
    public function show(SubCategory $subCategory)
    {
        return $this->render('sub_category/productsInSubCategory.html.twig', [
            'subCategory' => $subCategory
        ]);
    }

    /**
     * @Route("/delete-subCategory/{id}", name="delete_subCategory")
     *
     * @param SubCategory $subCategory
     *
     * @return RedirectResponse
     */
    public function delete(SubCategory $subCategory)
    {
        if (!$subCategory) {
            return $this->redirectToRoute('custom_cakes');
        }

        $this->subcategoryHandler->removeObject($subCategory);

        return $this->redirectToRoute('custom_cakes');
    }

    /**
     * @Route("/new-subCategory", name="new_subCategory")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $category= new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->subcategoryHandler->saveObject($category);
            $this->addFlash('success', 'new item created success!!!');

            return $this->redirectToRoute('custom_cakes');
        }

        return $this->render('sub_category/newSubCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-subCategory/{id}", name="edit_subCategory")
     *
     * @param SubCategory $subCategory
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(SubCategory $subCategory, Request $request)
    {
        $subCategory = $this
            ->subcategoryHandler
            ->getRepository(SubCategory::class)
            ->find($subCategory);

        $form = $this->createForm(SubCategoryType::class, $subCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->subcategoryHandler->saveObject($subCategory);
            $this->addFlash('success', 'Success)))!');

            return $this->redirectToRoute('custom_cakes');
        }

        return $this->render('sub_category/editSubCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

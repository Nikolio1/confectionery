<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Handlers\ProductHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 */
class ProductController extends AbstractController
{
    /**
     * @var ProductHandler
     */
    public $productHandler;

    /**
     * ProductController constructor.
     * @param ProductHandler $productHandler
     */
    public function __construct(ProductHandler $productHandler)
    {
        $this->productHandler = $productHandler;
    }

    /**
     * @Route("/product/{id}", name="show_product")
     *
     * @param Product $product
     *
     * @return Response
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/delete-product/{id}", name="delete_product")
     *
     * @param Product $post
     *
     * @return RedirectResponse
     */
    public function delete(Product $post)
    {
        if (!$post) {
            return $this->redirectToRoute('categories');
        }
        $this->productHandler->removeObject($post);
        return $this->redirectToRoute('categories');
    }

    /**
     * @Route("/new-product", name="new_product")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $product= new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->productHandler->saveObject($product);
            $this->addFlash('success', 'new item created success!!!');
            return $this->redirectToRoute('categories');
        }
        return $this->render('product/newProduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-product/{id}", name="edit_product")
     *
     * @param Product $product
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Product $product, Request $request)
    {
        $product = $this->productHandler
            ->getRepository(Product::class)
            ->find($product);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->productHandler->saveObject($product);
            $this->addFlash('success', 'Success)))!');
            return $this->redirectToRoute('categories');
        }
        return $this->render('product/editProduct.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
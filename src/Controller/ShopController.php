<?php

namespace App\Controller;

use App\Entity\Shop;
use App\Form\Type\ShopType;
use App\Handlers\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    public $handler;

    /**
    public $handler;
    /**
     * NewsController constructor.
     * @param BaseHandler $handler

     */
    public function __construct(BaseHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     *  @Route("/branded-stores", name="branded_stores")
     *
     * @return Response
     */
    public function branded_stores()
    {
        $shops= $this->handler
            ->getRepository(Shop::class)
            ->findBy(
                ['isBranded' => true]
            );

        return $this->render('shop/branded_stores.html.twig', [
            'shops' => $shops,
        ]);
    }

    /**
     * @Route("/store/{id}", name="show_store")
     *
     * @param Shop $shop
     *
     * @return Response
     */
    public function show(Shop $shop)
    {
        return $this->render('shop/show_store.html.twig', [
            'shop' => $shop
        ]);
    }

    /**
     * @Route("/delete-shop/{id}", name="delete_shop")
     *
     * @param Shop $post
     *
     * @return RedirectResponse
     */
    public function delete(Shop $post)
    {
        if (!$post) {
            return $this->redirectToRoute('branded_stores');
        }
        $this->handler->removeObject($post);
        return $this->redirectToRoute('branded_stores');
    }

    /**
     * @Route("/new-shop", name="new_shop")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $shop = new Shop();
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->saveObject($shop);
            $this->addFlash('success', 'new shop created success!!!');
            return $this->redirectToRoute('branded_stores');
        }
        return $this->render('shop/newShop.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-shop/{id}", name="edit_shop")
     *
     * @param Shop $shop
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Shop $shop, Request $request)
    {
        $shop = $this->handler
            ->getRepository(Shop::class)
            ->find($shop);
        $form = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->saveObject($shop);
            $this->addFlash('success', 'Success)))!');
            return $this->redirectToRoute('branded_stores');
        }
        return $this->render('shop/editShop.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

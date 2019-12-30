<?php

namespace App\Controller;

use App\Entity\District;
use App\Form\Type\DistrictType;
use App\Handlers\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DistrictController
 *
 * @package App\Controller
 */
class DistrictController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    public $handler;

    /**
     * DistrictController constructor.
     *
     * @param BaseHandler $handler
     */
    public function __construct(BaseHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/districts", name="districts")
     *
     * @return Response
     */
    public function districts()
    {
        $districts= $this
            ->handler
            ->getRepository(District::class)
            ->findAll();

        return $this->render('district/districts.html.twig', [
            'title'     => 'Districts',
            'districts' => $districts,
        ]);
    }

    /**
     * @Route("/district/{id}", name="show_district")
     *
     * @param District $district
     *
     * @return Response
     */
    public function show(District $district)
    {
        return $this->render('district/showsStoresInDistrict.html.twig', [
            'district' => $district
        ]);
    }

    /**
     * @Route("/delete-district/{id}", name="delete_district")
     *
     * @param District $district
     *
     * @return RedirectResponse
     */
    public function delete(District $district)
    {
        if (!$district) {
            return $this->redirectToRoute('districts');
        }

        $this->handler->removeObject($district);

        return $this->redirectToRoute('districts');
    }

    /**
     * @Route("/new-district", name="new_district")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $district = new District();

        $form = $this->createForm(DistrictType::class, $district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->saveObject($district);
            $this->addFlash('success', 'new shop created success!!!');

            return $this->redirectToRoute('districts');
        }

        return $this->render('district/newDistrict.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-district/{id}", name="edit_district")
     *
     * @param District $district
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(District $district, Request $request)
    {
        $district = $this
            ->handler
            ->getRepository(District::class)
            ->find($district);

        $form = $this->createForm(DistrictType::class, $district);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->saveObject($district);
            $this->addFlash('success', 'Success)))!');

            return $this->redirectToRoute('districts');
        }

        return $this->render('district/editDistrict.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

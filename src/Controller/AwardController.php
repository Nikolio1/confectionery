<?php

namespace App\Controller;

use App\Entity\Award;
use App\Form\Type\AwardType;
use App\Handlers\BaseHandler;
use App\Handlers\UploadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AwardController
 *
 * @package App\Controller
 */
class AwardController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    public $handler;

    /**
     * @var UploadHandler
     */
    public $uploadHandler;

    /**
     * AwardController constructor.
     *
     * @param BaseHandler $handler
     * @param UploadHandler $uploadHandler
     */
    public function __construct(BaseHandler $handler , UploadHandler $uploadHandler)
    {
        $this->handler = $handler;
        $this->uploadHandler = $uploadHandler;
    }

    /**
     * @Route("/awards", name="awards")
     * @param Request $request
     * @return Response
     */
    public function listAction( Request $request)
    {
        $awards = $this
            ->handler
            ->getRepository(Award::class)
            ->findAll();

        return $this->render('award/awards.html.twig', [
            'title' => 'Awards',
            'awards' => $awards
            ]
        );
    }


    /**
     * @Route("/award/{id}", name="show_award")
     *
     * @param Award $award
     *
     * @return Response
     */
    public function show(Award $award)
    {
        return $this->render('award/showAward.html.twig', [
            'award' => $award
        ]);
    }

    /**
     * @Route("/delete-award/{id}", name="delete_award")
     *
     * @param Award $award
     *
     * @return RedirectResponse
     */
    public function delete(Award $award)
    {
        if (!$award) {

            return $this->redirectToRoute('awards');
        }
        $this->handler->removeObject($award);
        return $this->redirectToRoute('awards');
    }

    /**
     * @Route("/create-award", name="new_award")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $award = new Award();

        $form = $this->createForm(AwardType::class, $award);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['imageName']->getData();

            if ($imageFile) {
                $imageFileName = $this->uploadHandler->upload($imageFile , '/award');
                $award->setImageName($imageFileName);
            }

            $this->handler->saveObject($award);
            $this->addFlash('success', 'new item created success!!!');

            return $this->redirectToRoute('awards');
        }

        return $this->render('award/newAward.html.twig', [
            'title' => 'New award',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-award/{id}", name="edit_award")
     *
     * @param Award $award
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Award $award, Request $request)
    {
        $award = $this
            ->handler
            ->getRepository(Award::class)
            ->find($award);

        $form = $this->createForm(AwardType::class, $award);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form['imageName']->getData();
            if ($imageFile) {
                $imageFileName = $this->uploadHandler->upload($imageFile , '/award');
                $award->setImageName($imageFileName);
            }

            $this->handler->saveObject($award);
            $this->addFlash('success', 'Success)))!');

            return $this->redirectToRoute('awards');
        }

        return $this->render('award/editAward.html.twig', [
            'title' => 'Edit award',
            'form'  => $form->createView(),
        ]);
    }
}

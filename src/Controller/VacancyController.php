<?php

namespace App\Controller;

use App\Entity\ResponseVacancy;
use App\Entity\Vacancy;
use App\Form\Type\ResponseVacancyType;
use App\Form\Type\VacancyType;
use App\Handlers\VacancyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class VacancyController
 *
 * @package App\Controller
 */
class VacancyController extends AbstractController
{
    /**
     * @var VacancyHandler
     */
    public $vacancyHandler;

    /**
     * VacancyController constructor.
     *
     * @param VacancyHandler $vacancyHandler
     */
    public function __construct(VacancyHandler $vacancyHandler)
    {
        $this->vacancyHandler = $vacancyHandler;
    }

    /**
     * @Route("/vacancies", name="vacancies")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function vacancies(Request $request)
    {
        $vacancies = $this
            ->vacancyHandler
            ->getRepository(Vacancy::class)
            ->findAll();

        $vacancy = new ResponseVacancy();

        $form = $this->createForm(ResponseVacancyType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->vacancyHandler->saveObject($vacancy);
            $this->addFlash('success', 'new item created successfully!!!');

            return $this->redirectToRoute('vacancies');
        }

        return $this->render('vacancy/index.html.twig', [
            'vacancies' => $vacancies,
            'form'      => $form->createView()
        ]);
    }


    /**
     * @Route("/vacancy/{id}", name="show_vacancy")
     *
     * @param Vacancy $vacancy
     *
     * @return Response
     */
    public function show(Vacancy $vacancy)
    {
        return $this->render('vacancy/vacancy.html.twig', [
            'vacancy' => $vacancy
        ]);
    }

    /**
     * @Route("/delete-vacancy/{id}", name="delete_vacancy")
     *
     * @param Vacancy $vacancy
     *
     * @return RedirectResponse
     */
    public function delete(Vacancy $vacancy)
    {
        if (!$vacancy) {
            return $this->redirectToRoute('vacancies');
        }

        $this->vacancyHandler->removeObject($vacancy);

        return $this->redirectToRoute('vacancies');
    }

    /**
     * @Route("/create-vacancy", name="create_vacancy")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $vacancy = new Vacancy();

        $form = $this->createForm(VacancyType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->vacancyHandler->saveObject($vacancy);
            $this->addFlash('success', 'new item created success!!!');

            return $this->redirectToRoute('vacancies');
        }

        return $this->render('vacancy/createVacancy.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-vacancy/{id}", name="edit_vacancy")
     *
     * @param Vacancy $vacancy
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(Vacancy $vacancy, Request $request)
    {
        $vacancy = $this
            ->vacancyHandler
            ->getRepository(vacancy::class)
            ->find($vacancy);

        $form = $this->createForm(VacancyType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->vacancyHandler->saveObject($vacancy);
            $this->addFlash('success', 'Success)))!');

            return $this->redirectToRoute('vacancies');
        }

        return $this->render('vacancy/editVacancy.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

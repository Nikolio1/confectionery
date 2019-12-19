<?php

namespace App\Controller;

use App\Entity\ResponseVacancy;
use App\Entity\Vacancy;
use App\Form\Type\ResponseVacancyType;
use App\Handlers\VacancyHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VacancyController extends AbstractController
{

    public $handler;

    /**
     * VacancyController constructor.
     * @param VacancyHandler $handler
     */
    public function __construct(VacancyHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/vacancies", name="vacancies")
     *
     * @param Request $request
     * @return Response
     */
    public function vacancies(Request $request)
    {
        $vacancies = $this->handler
            ->getRepository(Vacancy::class)
            ->findAll();

        $response = new ResponseVacancy();
        $form = $this->createForm(ResponseVacancyType::class, $response);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->saveObject($response);
            $this->addFlash('success', 'new item created successfully!!!');

            return $this->redirectToRoute('vacancies');
        }


        return $this->render('vacancy/index.html.twig', [
            'vacancies' => $vacancies,
            'form' => $form->createView()
        ]);
    }
}

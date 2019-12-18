<?php

namespace App\Controller;

use App\Entity\Vacancy;
use App\Handlers\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VacancyController extends AbstractController
{
    public $base;

    /**
     * VacancyController constructor.
     *
     * @param BaseHandler $base
     */
    public function __construct(BaseHandler $base)
    {
        $this->base = $base;
    }

    /**
     * @Route("/vacancies", name="vacancies")
     */
    public function vacancies()
    {


        $vacancies = $this->base
            ->getRepository(Vacancy::class)
            ->findAll();
        if (!$vacancies) {
            throw $this->createNotFoundException(
                'No event found'
            );
        }
        return $this->render('vacancy/index.html.twig', [
            'vacancies' => $vacancies
        ]);
    }
}

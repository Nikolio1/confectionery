<?php

namespace App\Controller;

use App\Entity\News;
use App\Handlers\NewsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public $newsHandler;
    /**
     * NewsController constructor.
     * @param NewsHandler $newsHandler
     */
    public function __construct(NewsHandler $newsHandler)
    {
        $this->newsHandler = $newsHandler;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $allNews = $this->newsHandler
            ->getRepository(News::class)
            ->findAll();
        return $this->render('index/index.html.twig', [
            'allNews' => $allNews
        ]);
    }

    /**
     * @Route("/about_company", name="about_company")
     */
    public function aboutCompany()
    {
        return $this->render('index/about_company.html.twig');
    }
}

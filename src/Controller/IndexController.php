<?php

namespace App\Controller;

use App\Entity\News;
use App\Handlers\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
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
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $allNews = $this->handler
            ->getRepository(News::class)
            ->findBy(
                [],
                ['id' => 'DESC'],
                 4
                          );

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

<?php

namespace App\Controller;

use App\Entity\News;
<<<<<<< HEAD
use App\Handlers\BaseHandler;
=======
use App\Handlers\NewsHandler;
>>>>>>> f6281e77c9ff7a08528e146d09e4215107e87d4f
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
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
     * @var BaseHandler
     */
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
     *  @Route("/", name="homepage")
     *
     * @return Response
     */
    public function index()
    {
<<<<<<< HEAD
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
=======
        $allNews = $this->newsHandler
            ->getRepository(News::class)
            ->findAll();

        return $this->render('index/index.html.twig', [
            'allNews' => $allNews
            ]);
>>>>>>> f6281e77c9ff7a08528e146d09e4215107e87d4f
    }

    /**
     * @Route("/about-company", name="about_company")
     *
     * @return Response
     */
    public function aboutCompany()
    {
        return $this->render('index/about_company.html.twig');
    }

    /**
     * @Route("/stores", name="stores")
     *
     * @return Response
     */
    public function stores()
    {
        return $this->render('index/stores.html.twig');
    }
}

<?php

namespace App\Controller;

use App\Entity\News;
use App\Handlers\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 *
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    public $handler;

    /**
     * NewsController constructor
     * .
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
        $allNews = $this
            ->handler
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

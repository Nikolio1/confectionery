<?php

namespace App\Controller;

use App\Entity\News;
use App\Handlers\NewsHandler;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
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
     * @Route("/all-news", name="all_news")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function listAction(PaginatorInterface $paginator, Request $request)
    {
        $query =  $this->newsHandler
            ->getRepository(News::class)
            ->findAllNews();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('news/allNews.html.twig', ['pagination' => $pagination]);
    }


    /**
     * @Route("/news/{id}", name="show_news")
     * @param News $news
     * @return Response
     */
    public function show(News $news)
    {
        return $this->render('news/news.html.twig', [
            'news' => $news
        ]);
    }
}

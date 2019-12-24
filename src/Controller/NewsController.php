<?php

namespace App\Controller;

use App\Entity\News;
use App\Form\Type\NewsType;
use App\Handlers\NewsHandler;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    /**
     * @Route("/delete-news/{id}", name="delete_news")
     *
     * @param News $post
     *
     * @return RedirectResponse
     */
    public function delete(News $post)
    {
        if (!$post) {
            return $this->redirectToRoute('categories');
        }
        $this->newsHandler->removeObject($post);
        return $this->redirectToRoute('all_news');
    }

    /**
     * @Route("/create-news", name="create_news")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function new(Request $request)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->newsHandler->saveObject($news);
            $this->addFlash('success', 'new item created success!!!');
            return $this->redirectToRoute('all_news');
        }
        return $this->render('news/newNews.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit-news/{id}", name="edit_news")
     *
     * @param News $news
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function edit(News $news, Request $request)
    {
        $news = $this->newsHandler
            ->getRepository(News::class)
            ->find($news);
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->newsHandler->saveObject($news);
            $this->addFlash('success', 'Success)))!');
            return $this->redirectToRoute('all_news');
        }
        return $this->render('news/editNews.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

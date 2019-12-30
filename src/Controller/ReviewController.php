<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\Type\ReviewType;
use App\Handlers\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReviewController
 *
 * @package App\Controller
 */
class ReviewController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    public $handler;

    /**
     * ReviewController constructor.
     *
     * @param BaseHandler $handler
     */
    public function __construct(BaseHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @Route("/reviews", name="reviews")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function reviews(Request $request)
    {
        $reviews = $this
            ->handler
            ->getRepository(Review::class)
            ->findBy(
                ['isValidated' => true]
            );

        $review = new Review();

        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->saveObject($review);
            $this->addFlash('successReview', 'Review successfully sent for moderation');

            return $this->redirectToRoute('reviews');
        }

        return $this->render('review/reviews.html.twig', [
            'title'   => 'Reviews',
            'reviews' => $reviews,
            'form'    => $form->createView()
        ]);
    }
}

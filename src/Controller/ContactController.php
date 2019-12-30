<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\Type\ContactType;
use App\Handlers\BaseHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 *
 * @package App\Controller
 */
class ContactController extends AbstractController
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
     * @Route("/contact", name="contact")
     *
     * @param Request $request
     *
     * @return Response
     */
    public function contact(Request $request)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->saveObject($contact);
            $this->addFlash('successContact', 'Your message has been sent successfully');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'title' => 'Contacts',
            'form'  => $form->createView()
        ]);
    }
}

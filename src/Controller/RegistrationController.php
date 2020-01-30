<?php

namespace App\Controller;

use App\Form\Type\UserType;;
use App\Entity\User;
use App\Handlers\BaseHandler;
use App\Handlers\UploadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    public $handler;

    /**
     * @var UploadHandler
     */
    public $uploadHandler;

    /**
     * NewsController constructor.
     *
     * @param BaseHandler $handler
     * @param UploadHandler $uploadHandler
     */
    public function __construct(BaseHandler $handler , UploadHandler $uploadHandler)
    {
        $this->handler = $handler;
        $this->uploadHandler = $uploadHandler;
    }

    /**
     *  @Route("/register", name="user_registration")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return RedirectResponse|Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($password);

            $imageFileName = $this->uploadHandler->upload($user->getFile() , '/user');
            $user->setPhotoName($imageFileName);

            $this->handler->saveObject($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
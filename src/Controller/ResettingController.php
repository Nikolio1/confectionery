<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\ResettingPassword\ResettingPasswordType;
use App\Form\Type\ResettingPassword\ResettingType;
use App\Handlers\BaseHandler;
use App\Handlers\ResettingPasswordHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResettingController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    public $handler;

    /**
     * @var ResettingPasswordHandler
     */
    public $resetPassword;

    /**
     * @var UserPasswordEncoderInterface
     */
    public $passwordEncoder;

    /**
     * ResettingController constructor.
     *
     * @param BaseHandler $handler
     * @param ResettingPasswordHandler $resetPassword
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(BaseHandler $handler, ResettingPasswordHandler $resetPassword, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->handler = $handler;
        $this->resetPassword = $resetPassword;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/resetting", name="resetting")
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function sendEmailAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(ResettingType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form ->get('email')->getData();
            $user = $this
                ->handler
                ->getRepository(User::class)
                ->findOneBy(
                    ['email' => $email]
                );
            if (null === $user) {
                return $this->render('resetting/resetting.html.twig', [
                    'invalid_email' => $email,
                    'form'  => $form->createView()
                ]);
            } else {
                if ($this->resetPassword->tokenDateCheck($user->getResetTokenExpiresAt()) || (($user->getResetTokenExpiresAt()) === null)) {

                    $this->resetPassword->tokenRecordToUser($user);

                    $twig = $this->renderView('emails/resetPassword.html.twig',[
                        'user' => $user
                    ]);

                    $this->resetPassword->sendMail($user, $twig);

                    return $this->redirectToRoute('send_email');
                } else {
                    return $this->render('resetting/resetting.html.twig', array(
                        'invalid_token' => $email,
                        'form'  => $form->createView()
                    ));
                }
            }
        }

        return $this->render('resetting/resetting.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/resetting/send-email", name="send_email")
     *
     * @return Response
     */
    public function sendEmail()
    {
        return $this->render('resetting/send-email.html.twig', [
            'message' => ''
        ]);
    }

    /**
     * @Route("/resetting/new_password/{resetToken}", name="new_password")
     *
     * @param Request $request
     * @param User $user
     *
     * @return RedirectResponse|Response
     */
    public function restorationPassword(Request $request, User $user)
    {
        $form = $this->createForm(ResettingPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
            $this->resetPassword->deleteToken($user);
            $this->handler->saveObject($user);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('resetting/newPassword.html.twig', [
            'form'  => $form->createView()
        ]);
    }
}
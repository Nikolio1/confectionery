<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\User\UserEditPasswordType;
use App\Form\Type\User\UserEditProfileType;
use App\Handlers\BaseHandler;
use App\Handlers\UploadHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AccountController
 *
 * @package App\Controller
 */
class AccountController extends AbstractController
{
    /**
     * @var BaseHandler
     */
    protected $handler;

    /**
     * @var UploadHandler
     */
    protected $uploadHandler;

    /**
     * @var
     */
    protected $passwordEncoder;

    /**
     * AccountController constructor.
     *
     * @param BaseHandler $handler
     * @param UploadHandler $uploadHandler
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(BaseHandler $handler , UploadHandler $uploadHandler, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->handler = $handler;
        $this->uploadHandler = $uploadHandler;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/account", name="account")
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();

        $form = $this->createForm(UserEditPasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->passwordEncoder->isPasswordValid($user,$form->get('oldPassword')->getData())){
                $newPassword = $this->passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
                $user->setPassword($newPassword);
            }

            $this->handler->saveObject($user);
        }
        return $this->render('account/index.html.twig', [
            'user'  => $user,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/account/edit-profile", name="edit_profile")
     *
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function editProfile(Request $request)
    {
        /** var User $user */
        $user = $this->getUser();

        $form = $this->createForm(UserEditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getFile() instanceof UploadedFile) {
                $this->uploadHandler->removeFile($user->getPhotoName(), '/user');
                $fileName = $user->getPhotoName();
                $this->uploadHandler->removeFile($fileName, '/user');
                $imageFileName = $this->uploadHandler->upload($user->getFile() , '/user');
                $user->setPhotoName($imageFileName);
            }

            $this->handler->saveObject($user);

            return $this->redirectToRoute('account');
        }

        return $this->render('account/editProfile.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}

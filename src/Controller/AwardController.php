<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AwardController extends AbstractController
{
    /**
     * @Route("/awards", name="awards")
     */
    public function awards()
    {
        return $this->render('award/awards.html.twig', [
            'controller_name' => 'AwardController',
        ]);
    }
}

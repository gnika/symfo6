<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagazogController extends AbstractController
{
    #[Route('/tagazog', name: 'tagazogus')]
    public function index(): Response
    {
        return $this->render('tagazog/index.html.twig', [
            'controller_name' => 'TagazogController',
        ]);
    }
}

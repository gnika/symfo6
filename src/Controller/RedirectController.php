<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RedirectController extends AbstractController
{
    public function redirectToLocale(): Response
    {
        return $this->redirectToRoute('homepage2');
    }
}
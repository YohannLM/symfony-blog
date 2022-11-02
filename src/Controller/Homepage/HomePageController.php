<?php

namespace App\Controller\Homepage;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('homepage/homepage.html.twig');
    }
}

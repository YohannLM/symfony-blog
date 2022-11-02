<?php

namespace App\Controller\Homepage;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
	
	/**
	 * @param \App\Repository\PropertyRepository $repository
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	#[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(PropertyRepository $repository): Response
    {
		$properties = $repository->findLatest();
        return $this->render('homepage/homepage.html.twig', [
			'properties' => $properties
        ]);
    }
}

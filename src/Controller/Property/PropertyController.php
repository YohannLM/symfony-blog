<?php

namespace App\Controller\Property;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController {
	
	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	#[Route('/biens', name: 'property.index')]
	public function index(): Response
	{
		return $this->render('property/index.html.twig', [
			'current_menu' => 'properties'
		]);
	}
}

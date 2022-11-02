<?php

namespace App\Controller\Property;

use App\Entity\Property;
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
	
	#[Route('/biens/{slug}-{id}', name: 'property.show', requirements: ["slug" => "[a-z0-9\-]*"])]
	public function show(Property $property, string $slug): Response
	{
		if ($property->getSlug() !== $slug) {
			return $this->redirectToRoute('property.show', [
				'id' => $property->getId(),
				'slug' => $property->getSlug()
			], 301);
		}
		return $this->render('property/show.html.twig', [
			'property' => $property,
			'current_menu' => 'properties'
		]);
	}
	
}

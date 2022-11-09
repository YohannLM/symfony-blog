<?php

namespace App\Controller\Property;

use App\Entity\Property;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController {
	
	/**
	 * @var \App\Repository\PropertyRepository
	 */
	private PropertyRepository $repository;
	
	public function __construct( PropertyRepository $repository ) {
		$this->repository = $repository;
	}
	
	/**
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	#[Route('/biens', name: 'property.index')]
	public function index(PaginatorInterface $paginator, Request $request): Response
	{
		// Create new search
		$search = new PropertySearch();
		// Create search form with search property
		$form = $this->createForm(PropertySearchType::class, $search);
		// Handle request on form
		$form->handleRequest($request);
		
		// Create properties pagination
		$properties = $paginator->paginate(
			$this->repository->findAllVisibleQuery($search),
			$request->query->getInt('page', 1),
			12
			
		);
		
		return $this->renderForm('property/index.html.twig', [
			'current_menu' => 'properties',
			'properties' => $properties,
			'form_search' => $form
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

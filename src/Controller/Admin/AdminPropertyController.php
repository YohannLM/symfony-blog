<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertyController extends AbstractController {
	
	
	/**
	 * @var \App\Repository\PropertyRepository
	 */
	private PropertyRepository $repository;
	/**
	 * @var \Doctrine\ORM\EntityManagerInterface
	 */
	private EntityManagerInterface $em;
	
	public function  __construct(PropertyRepository $repository, EntityManagerInterface $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}
	
	#[Route("/admin", name: "admin.property.index")]
	public function index(): Response
	{
		$properties = $this->repository->findAll();
		return $this->render('admin/property/index.html.twig', compact('properties'));
	}
	
	#[Route("/admin/property/create", name: "admin.property.new")]
	public function new(Request $request): Response
	{
		$property = new Property();
		
		$form = $this->createForm(PropertyType::class, $property);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			// Persist and flush
			$this->em->persist($property);
			$this->em->flush();
			$this->addFlash('success', 'Le bien a été créé.');
			return $this->redirectToRoute('admin.property.index');
		}
		
		return $this->renderForm('admin/property/new.html.twig', [
			'property' => $property,
			'form' => $form
		]);
	
	}
	
	#[Route("/admin/property/{id}", name: "admin.property.edit", methods: ["POST", "GET"])]
	public function edit(Property $property, Request $request): Response
	
	{
//		$option = new Option();
//		$property->addOption($option);
		
		$form = $this->createForm(PropertyType::class, $property);
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			// Save in db
			$this->em->flush();
			// Success message
			$this->addFlash('success', 'Les modifications ont été sauvegardées.');
			return $this->redirectToRoute('admin.property.index');
		}
		
		return $this->renderForm('admin/property/edit.html.twig', [
			'property' => $property,
			'form' => $form
		]);
	}
	
	#[Route("/admin/property/delete/{id}", name: "admin.property.delete", methods: ["POST"])]
	public function delete(Property $property, Request $request): Response {
		
		if ($this->isCsrfTokenValid('delete'.$property->getId(), $request->get('_token'))) {
			$this->repository->remove($property, true);
			$this->addFlash('success', 'Le bien a été supprimé.');
		}
		return $this->redirectToRoute("admin.property.index");

	}
}

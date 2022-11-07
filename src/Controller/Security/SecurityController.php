<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
	
	#[Route('/login', name: 'security.login', methods: ['GET', 'POST'])]
	public function login(AuthenticationUtils $authenticationUtils): Response {
		
		return $this->render('security/login.html.twig', [
			'last_username' => $authenticationUtils->getLastUsername(),
			'error' => $authenticationUtils->getLastAuthenticationError()
		]);
	}
	
	
	#[Route( '/logout', name: 'security.logout', methods: ['GET'] )]
	public function logout( AuthenticationUtils $authenticationUtils ) {
		// controller can be blank: it will never be called!
		throw new \Exception('Don\'t forget to activate logout in security.yaml');
	}
	
	

}


<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
    
    #[Route('/test/{name}/{age}', name: 'app_test')]
    public function testF($name, $age): Response
    {
       return $this->render('service/test.html.twig', [
           'n' => $name,
           'a' => $age
       ]);
    }

    #[Route('/GoIndex', name: 'app_GoIndex')]
    public function GoIndex(): Response
    {
          return $this->redirectToRoute('app_home');
   
    }
}

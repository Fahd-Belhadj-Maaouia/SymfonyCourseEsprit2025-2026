<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/racine')]
class homeController extends AbstractController
{
    #[Route('/Home',name:'app_home')]
    public function Home():Response
    {
        return new Response ("testest");
    
    }
}
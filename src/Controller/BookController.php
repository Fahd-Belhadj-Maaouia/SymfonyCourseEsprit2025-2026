<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/listbook', name: 'app_book_list')]
    public function affiche(BookRepository $repo):Response
    {
        $book=$repo->findAll();
        return $this->render('book/affiche.html.twig', [
            'book'=>$book
        ]);

    }
    #[Route('/addbook', name: 'app_book_add')]
    public function add(EntityManagerInterface $em, Request $request): Response
    {
         $book = new Book();
    $form = $this->CreateForm(BookType::class,$book);
    $form->add('Ajouter',SubmitType::class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
        $em->persist($book);
        $em->flush($book);
        return $this->redirectToRoute('app_book_list');
    }
    return $this->render('book/add.html.twig',[
        'f'=>$form->createView()
    ]);
    }
}

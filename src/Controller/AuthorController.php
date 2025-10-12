<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use PhpParser\Node\Expr\New_;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpClient\Messenger\PingWebhookMessage;
use Symfony\Component\HttpFoundation\Request;

final class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

     #[Route('/listAuthors', name: 'app_listAuthors')]
    public function listAuthors(): Response
    {

        $authors = array(
array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
'victor.hugo@gmail.com ', 'nb_books' => 100),
array('id' => 2, 'picture' => '/images/william.jpg','username' => ' William Shakespeare', 'email' =>
' william.shakespeare@gmail.com', 'nb_books' => 200 ),
array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
'taha.hussein@gmail.com', 'nb_books' => 300),
);
        return $this->render('author/list.html.twig', [
            'authors' => $authors
        ]);
    }


    #[Route('/authorDetails', name: 'authordetails')]
    public function details(): Response
    {
        return $this->render('author/details.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
    






    
 #[Route('/authorDetails/{id}', name: 'app_author_details')]
public function authorDetails($id): Response
{
    $authors = [
        ['id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com', 'nb_books' => 100],
        ['id' => 2, 'picture' => '/images/william.jpg','username' => 'William Shakespeare', 'email' =>
        'william.shakespeare@gmail.com', 'nb_books' => 200],
        ['id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300],
    ];

    $author = null;
    foreach ($authors as $a) {
        if ($a['id'] == $id) {
            $author = $a;
            break;
        }
    }

    if (!$author) {
        throw $this->createNotFoundException("Author with id $id not found");
    }

    return $this->render('author/details.html.twig', [
        'author' => $author
    ]);
}
#[Route('/listAuthor', name: 'app_author_list')]
public function show(AuthorRepository $repoAuthor) : Response
{
    $list = $repoAuthor->findAll();
    return $this->render('author/affiche.html.twig', [
        'author' => $list
    ]);

}

#[Route('/AddStatic', name: 'app_Add_Static')]
public function AddStatic(EntityManagerInterface $em): Response
{
$author1 = new Author();
    $author1->setUsername("Ahmed");
    $author1->setEmail("ahmed@gmail.com");
    $em->persist($author1);
    $em->flush();
    return $this->redirectToRoute('app_author_list');
}
#[Route('/Add', name: 'app_author_Add')]
public function Add(EntityManagerInterface $em,Request $request):Response
{
    $author = new Author();
    $form = $this->CreateForm(AuthorType::class,$author);
    $form->add('Ajouter',SubmitType::class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
        $em->persist($author);
        $em->flush($author);
        return $this->redirectToRoute('app_author_list');
    }
    return $this->render('author/add.html.twig',[
        'f'=>$form->createView()
    ]);
}
    #[Route('/Edit/{id}', name: 'app_author_Edit')]
    public function Edit($id,EntityManagerInterface $em, Request $request, AuthorRepository $repo):Response
    {
        $author = $repo->find($id);
        $form = $this->CreateForm(AuthorType::class,$author);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($author);
            $em->flush($author);
            return $this->redirectToRoute('app_author_list');
        }
         return $this->render('author/edit.html.twig',[
        'f'=>$form->createView()
    ]);

        
    }
    #[Route('/Delete/{id}', name: 'app_author_Delete')]
    public function Delete($id,EntityManagerInterface $em, AuthorRepository $repo):Response
    {
        $author = $repo->find($id);
        if(!$author)
        {
            throw $this->createNotFoundException("famech");
        }
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_author_list');

        
    }


}
   
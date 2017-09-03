<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SingleAuthorController extends Controller
{
    /**
     * @Route("/authors/{id}", name="singleAuthor")
     */
    public function indexAction(Request $request, int $id)
    {
        $repositoryAuthors = $this->getDoctrine()->getRepository(Authors::class);
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);

        $authors = $repositoryAuthors->findOneByIdauthors($id);
        if ($authors == null) {
            $this->addFlash('notice', 'Author not found');
            return $this->redirectToRoute('authors');
        }
        $books = $repositoryBooks->findByAuthorsauthors($id);


        return $this->render('home/singleAuthor.html.twig', [
            'authors' => $authors,
            'books' => $books

        ]);
    }
}

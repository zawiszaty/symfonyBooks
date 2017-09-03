<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Books;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SingleBookController extends Controller
{
    /**
     * @Route("/book/{id}", name="singleBook")
     */
    public function indexAction(Request $request, int $id)
    {


        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);

        $book = $repositoryBooks->findOneByIdbooks($id);
        if ($book == null) {
            $this->addFlash('info', 'Books not found');
            return $this->redirectToRoute('homepage');
        }


        return $this->render('home/singleBook.html.twig', [

            'book' => $book

        ]);
    }
}

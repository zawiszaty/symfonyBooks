<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);

        $books = $repositoryBooks->findAll();


        return $this->render('home/index.html.twig', [
            'books' => $books,

        ]);
    }
}

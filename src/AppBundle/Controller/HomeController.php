<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use AppBundle\Utils\BookLogic\GetAllBooks;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, GetAllBooks $getAllBooks): Response
    {
        $books = $this->get(GetAllBooks::class)->getAllBooks($this->getDoctrine());

        return $this->render('home/index.html.twig', [
            'books' => $books,
        ]);
    }
}

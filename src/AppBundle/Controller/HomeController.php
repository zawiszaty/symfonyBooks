<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use AppBundle\Utils\BooksLogic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * This method get all Books
     *
     * @param Request    $request    request object
     * @param BooksLogic $booksLogic Books buisness logic
     *
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, BooksLogic $booksLogic): Response
    {
        $books = $booksLogic->getAllBooks($this->getDoctrine());
        return $this->render('home/index.html.twig', ['books' => $books,]);
    }
}

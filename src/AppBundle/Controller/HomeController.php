<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Book;
use AppBundle\Utils\BookLogic;
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
     * @param Request   $request   request object
     * @param BookLogic $bookLogic Books buisness logic
     *
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, BookLogic $bookLogic): Response
    {
        $books = $bookLogic->getAllBooks($this->getDoctrine());
        return $this->render('home/index.html.twig', ['books' => $books,]);
    }
}

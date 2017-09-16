<?php

namespace AppBundle\Controller;

use AppBundle\Utils\AuthorLogic;
use AppBundle\Utils\BooksLogic;
use AppBundle\Utils\CategoryLogic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PanelController
 * @package AppBundle\Controller
 */
class PanelController extends Controller
{
    /**
     * Get all books and category and authors
     *
     * @param Request       $request       object object
     * @param BooksLogic    $booksLogic    bookslogic object
     * @param AuthorLogic   $authorLogic   AuthorLogic
     * @param CategoryLogic $categoryLogic category
     *
     * @return Response
     *
     * @Route("/panel", name="panel")
     */
    public function indexAction(Request $request, BooksLogic $booksLogic, AuthorLogic $authorLogic, CategoryLogic $categoryLogic): Response
    {
        $authors = $authorLogic->getAllAuthors($this->getDoctrine());
        $books = $booksLogic->getAllBooks($this->getDoctrine());
        $category = $categoryLogic->getAllCategory($this->getDoctrine());
        return $this->render('panel/index.html.twig', ['books' => $books, 'category' => $category, 'authors' => $authors,]);
    }
}

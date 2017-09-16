<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use AppBundle\Utils\AuthorLogic;
use AppBundle\Utils\BooksLogic;
use AppBundle\Utils\CategoryLogic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanelController extends Controller
{
    /**
     * @Route("/panel", name="panel")
     */
    public function indexAction(Request $request, BooksLogic $booksLogic, AuthorLogic $authorLogic, CategoryLogic $categoryLogic)
    {
        $authors = $this->get(AuthorLogic::class)->getAllAuthors($this->getDoctrine());
        $books = $this->get(BooksLogic::class)->getAllBooks($this->getDoctrine());
        $category = $this->get(CategoryLogic::class)->getAllCategory($this->getDoctrine());
        return $this->render('panel/index.html.twig', [
            'books' => $books,
            'category' => $category,
            'authors' => $authors,
        ]);
    }
}

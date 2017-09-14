<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use AppBundle\Utils\AuthorLogic\GetAllAuthor;
use AppBundle\Utils\BookLogic\GetAllBooks;
use AppBundle\Utils\CategoryLogic\GetAllCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanelController extends Controller
{
    /**
     * @Route("/panel", name="panel")
     */
    public function indexAction(Request $request, GetAllAuthor $getAllAuthor, GetAllBooks $getAllBooks, GetAllCategory $getAllCategory)
    {
        $authors = $this->get(GetAllAuthor::class)->getAllAuthors($this->getDoctrine());
        $books = $this->get(GetAllBooks::class)->getAllBooks($this->getDoctrine());
        $category = $this->get(GetAllCategory::class)->getAllCategory($this->getDoctrine());
        return $this->render('panel/index.html.twig', [
            'books' => $books,
            'category' => $category,
            'authors' => $authors,
        ]);
    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use AppBundle\Form\AddBooksType;
use AppBundle\Form\EditBookType;
use AppBundle\Utils\BooksLogic;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BookController
 * @package AppBundle\Controller
 */
class BookController extends Controller
{
    /**
     * This method added book
     *
     * @param Request    $request    request object
     * @param BooksLogic $booksLogic Books Buisnesss
     *
     * @return Response
     *
     * @Route("/panel/add/books", name="addBooks")
     */
    public function addBooks(Request $request, BooksLogic $booksLogic): Response
    {
        $form = $this->createForm(AddBooksType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($booksLogic->addBook($task, $this->getDoctrine())) {
                $this->addFlash(
                    'info',
                    'Your changes were saved!'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Error'
                );
            }
            return $this->redirectToRoute('panel');
        }
        return $this->render('panel/addBook.html.twig', array('form' => $form->createView(),));

    }

    /**
     * This method get single Book
     *
     * @param Request    $request    request object
     * @param int        $id         book id
     * @param BooksLogic $booksLogic Books Buisnesss
     *
     * @return Response
     *
     * @Route("/book/{id}", name="singleBook", requirements={"id": "\d+"})
     */
    public function singleBook(Request $request, int $id, BooksLogic $booksLogic): Response
    {
        $book = $booksLogic->getSingleBook($id, $this->getDoctrine());
        if (!$book) {
            $this->addFlash('danger', 'Books not found');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('home/singleBook.html.twig', ['book' => $book]);
    }

    /**
     * This method del single Book
     *
     * @param Request    $request    request object
     * @param int        $id         book id
     * @param BooksLogic $booksLogic Books Buisnesss
     *
     * @return Response
     *
     * @Route("/panel/del/book/{id}", name="delBook", requirements={"id": "\d+"})
     */
    public function delBook(Request $request, int $id, BooksLogic $booksLogic): Response
    {
        $books = $booksLogic->getSingleBook($id, $this->getDoctrine());
        if ($booksLogic->delBook($books, $this->getDoctrine())) {
            $this->addFlash(
                'info',
                'Your changes were saved!'
            );
        } else {
            $this->addFlash(
                'danger',
                'Error'
            );
        }
        return $this->redirectToRoute('panel');

    }

    /**
     * This method edit single Book
     *
     * @param Request    $request    request object
     * @param int        $id         book id
     * @param BooksLogic $booksLogic Books Buisnesss
     *
     * @return Response
     *
     * @Route("/panel/edit/book/{id}", name="editBook", requirements={"id": "\d+"})
     */
    public function editBook(Request $request, int $id, BooksLogic $booksLogic): Response
    {
        $books = $booksLogic->getSingleBook($id, $this->getDoctrine());
        if ($books->getIdbooks() == null) {
            $this->addFlash('danger', 'Books not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditBookType::class, $books);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($booksLogic->editBook($task, $this->getDoctrine())) {
                $this->addFlash(
                    'info',
                    'Your changes were saved!'
                );
            } else {
                $this->addFlash(
                    'Error',
                    'Error'
                );
            }
            return $this->redirectToRoute('panel');
        }
        return $this->render('panel/addBook.html.twig', array('form' => $form->createView()));

    }


}
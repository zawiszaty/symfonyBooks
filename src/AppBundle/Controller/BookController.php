<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use AppBundle\Form\AddBooksType;
use AppBundle\Form\EditBookType;
use AppBundle\Utils\BookLogic\AddBook;
use AppBundle\Utils\BookLogic\DelBook;
use AppBundle\Utils\BookLogic\EditBook;
use AppBundle\Utils\BookLogic\GetSingleBook;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    /**
     * @Route("/panel/add/books", name="addBooks")
     */
    public function addBooks(Request $request, AddBook $addBook): Response
    {
        $form = $this->createForm(AddBooksType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(AddBook::class)->addBook($task, $this->getDoctrine())) {
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
        return $this->render('panel/addBook.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/book/{id}", name="singleBook", requirements={"id": "\d+"})
     */
    public function singleBook(Request $request, int $id, GetSingleBook $getSingleBook): Response
    {
        $book = $this->get(GetSingleBook::class)->getSingleBook($id, $this->getDoctrine());
        if (!$book) {
            $this->addFlash('danger', 'Books not found');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('home/singleBook.html.twig', [
            'book' => $book
        ]);
    }

    /**
     * @Route("/panel/del/book/{id}", name="delBook", requirements={"id": "\d+"})
     */
    public function delBook(Request $request, int $id, DelBook $delBook, GetSingleBook $getSingleBook): Response
    {

        $books = $this->get(GetSingleBook::class)->getSingleBook($id, $this->getDoctrine());
        if ($this->get(DelBook::class)->delBook($books, $this->getDoctrine())) {
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
     * @Route("/panel/edit/book/{id}", name="editBook", requirements={"id": "\d+"})
     */
    public function editBook(Request $request, int $id, EditBook $editBook, GetSingleBook $getSingleBook): Response
    {
        $books = $this->get(GetSingleBook::class)->getSingleBook($id, $this->getDoctrine());
        if ($books->getIdbooks() == null) {
            $this->addFlash('danger', 'Books not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditBookType::class, $books);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(EditBook::class)->editBook($task, $this->getDoctrine())) {
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
        return $this->render('panel/addBook.html.twig', array(
            'form' => $form->createView(),
        ));

    }


}
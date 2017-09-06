<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use AppBundle\Form\AddBooksType;
use AppBundle\Form\EditBookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class BookController extends Controller
{
    /**
     * @Route("/panel/add/books", name="addBooks")
     * @Method("GET")
     */
    public function addBooks(Request $request): Response
    {
        $form = $this->createForm(AddBooksType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            $this->addFlash(
                'info',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('panel');
        }
        return $this->render('panel/addBook.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    /**
     * @Route("/book/{id}", name="singleBook", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function singleBook(Request $request, int $id): Response
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

    /**
     * @Route("/panel/del/book/{id}", name="delBook", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function indexAction(Request $request, int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Books::class);
        $books = $repository->findOneByIdbooks($id);
        if ($books == null) {
            $this->addFlash('info', 'Book not found');
            return $this->redirectToRoute('panel');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($books);
        $em->flush();
        $this->addFlash(
            'info',
            'Your changes were saved!'
        );
        return $this->redirectToRoute('panel');

    }

    /**
     * @Route("/panel/edit/book/{id}", name="editBook", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function editBook(Request $request, int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Books::class);
        $books = $repository->findOneByIdbooks($id);
        if ($books == null) {
            $this->addFlash('notice', 'Books not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditBookType::class, $books);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            $this->addFlash(
                'info',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('panel');
        }
        return $this->render('panel/addBook.html.twig', array(
            'form' => $form->createView(),
        ));

    }


}
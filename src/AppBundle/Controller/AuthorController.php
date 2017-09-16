<?php

namespace AppBundle\Controller;

use AppBundle\Form\AddAuthorType;
use AppBundle\Form\EditAuthorType;
use AppBundle\Utils\AuthorLogic;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class AuthorController extends Controller
{
    /**
     * @Route("/authors", name="authors")
     */
    public function getAllAuthors(Request $request, AuthorLogic $authorLogic): Response
    {
        $authors = $this->get(AuthorLogic::class)->getAllAuthors($this->getDoctrine());
        return $this->render('home/authors.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/panel/add/author", name="addAuthor")
     */
    public function addAuthor(Request $request, AuthorLogic $authorLogic): Response
    {
        $form = $this->createForm(AddAuthorType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(AuthorLogic::class)->addAuthor($task, $this->getDoctrine())) {
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
        return $this->render('panel/addAuthor.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/panel/del/author/{id}", name="delAuthor", requirements={"id": "\d+"})
     */
    public function delAuthor(Request $request, int $id, AuthorLogic $authorLogic): Response
    {
        $author = $this->get(AuthorLogic::class)->getSingleAuthor($id, $this->getDoctrine());
        if ($author->getIdauthors() == null) {
            $this->addFlash(
                'danger',
                'Error!'
            );
            return $this->redirectToRoute('panel');
        }
        $books = $this->get(AuthorLogic::class)->getAuthorBook($id, $this->getDoctrine());
        $authors = $this->get(AuthorLogic::class)->getSingleAuthor(5, $this->getDoctrine());
        $this->get(AuthorLogic::class)->removeAuthorBooks($authors, $books, $this->getDoctrine());
        if ($this->get(AuthorLogic::class)->delAuthor($author, $this->getDoctrine())) {
            $this->addFlash(
                'info',
                'Your changes were saved!'
            );
        } else {
            $this->addFlash(
                'danger',
                'Error!'
            );
        }
        return $this->redirectToRoute('panel');
    }

    /**
     * @Route("/panel/edit/author/{id}", name="editAuthor", requirements={"id": "\d+"})
     */
    public function editAuthor(Request $request, int $id, AuthorLogic $authorLogic): Response
    {
        $author = $this->get(AuthorLogic::class)->getSingleAuthor($id, $this->getDoctrine());
        if ($author->getIdauthors() == null) {
            $this->addFlash(
                'danger',
                'Error!'
            );
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditAuthorType::class, $author);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(AuthorLogic::class)->editAuthor($task, $this->getDoctrine())) {
                $this->addFlash(
                    'info',
                    'Your changes were saved!'
                );
            }
            return $this->redirectToRoute('homepage');
        }
        return $this->render('panel/addAuthor.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/authors/{id}", name="singleAuthor", requirements={"id": "\d+"})
     */
    public function getSingleAuthor(Request $request, int $id, AuthorLogic $authorLogic): Response
    {
        $author = $this->get(AuthorLogic::class)->getSingleAuthor($id, $this->getDoctrine());
        $books = $this->get(AuthorLogic::class)->getAuthorBook($id, $this->getDoctrine());
        if (!$author) {
            $this->addFlash(
                'danger',
                'Error'
            );
            return $this->redirectToRoute('panel');
        }
        return $this->render('home/singleAuthor.html.twig', [
            'authors' => $author,
            'books' => $books

        ]);
    }

}
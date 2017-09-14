<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Form\AddAuthorType;
use AppBundle\Form\EditAuthorType;
use AppBundle\Utils\AuthorLogic\AddAuthor;
use AppBundle\Utils\AuthorLogic\DelAuthor;
use AppBundle\Utils\AuthorLogic\EditAuthor;
use AppBundle\Utils\AuthorLogic\GetAllAuthor;
use AppBundle\Utils\AuthorLogic\GetAuthorBooks;
use AppBundle\Utils\AuthorLogic\GetSingleAuthor;
use AppBundle\Utils\CategoryLogic\AddCategory;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class AuthorController extends Controller
{
    /**
     * @Route("/authors", name="authors")
     */
    public function getAllAuthors(Request $request, GetAllAuthor $getAllAuthor): Response
    {
        $authors = $this->get(GetAllAuthor::class)->getAllAuthors($this->getDoctrine());
        return $this->render('home/authors.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/panel/add/author", name="addAuthor")
     */
    public function addAuthor(Request $request, AddAuthor $addAuthor): Response
    {
        $form = $this->createForm(AddAuthorType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(AddAuthor::class)->addAuthor($task, $this->getDoctrine())) {
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
    public function delAuthor(Request $request, int $id, DelAuthor $delAuthor, GetSingleAuthor $getSingleAuthor, GetAuthorBooks $getAuthorBooks): Response
    {
        $author = $this->get(GetSingleAuthor::class)->getSingleAuthor($id, $this->getDoctrine());
        if ($author->getIdauthors() == null) {
            $this->addFlash(
                'danger',
                'Error!'
            );
            return $this->redirectToRoute('panel');
        }
        $books = $this->get(GetAuthorBooks::class)->getAuthorBook($id, $this->getDoctrine());
        $authors = $this->get(GetSingleAuthor::class)->getSingleAuthor(5, $this->getDoctrine());
        foreach ($books as $item) {
            $item->setAuthorsauthors($authors);
        }
        if ($this->get(DelAuthor::class)->delAuthor($author, $this->getDoctrine())) {
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
    public function editAuthor(Request $request, int $id, EditAuthor $editAuthor, GetSingleAuthor $getSingleAuthor): Response
    {
        $author = $this->get(GetSingleAuthor::class)->getSingleAuthor($id, $this->getDoctrine());
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
            if ($this->get(EditAuthor::class)->editAuthor($task, $this->getDoctrine())) {
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
    public function getSingleAuthor(Request $request, int $id, GetSingleAuthor $getSingleAuthor, GetAuthorBooks $getAuthorBooks): Response
    {
        $author = $this->get(GetSingleAuthor::class)->getSingleAuthor($id, $this->getDoctrine());
        $books = $this->get(GetAuthorBooks::class)->getAuthorBook($id, $this->getDoctrine());
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
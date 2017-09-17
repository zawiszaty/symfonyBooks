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


/**
 * Class AuthorController
 *
 * @package AppBundle\Controller
 *
 */
class AuthorController extends Controller
{
    /**
     * This method get all authors
     *
     * @param Request     $request     request object
     * @param AuthorLogic $authorLogic AuthorLogic service
     *
     * @Route("/authors", name="authors")
     *
     * @return Response
     */
    public function getAllAuthors(Request $request, AuthorLogic $authorLogic): Response
    {
        $authors = $authorLogic->getAllAuthors($this->getDoctrine());
        return $this->render('home/authors.html.twig', ['authors' => $authors,]);
    }

    /**
     * This method added author
     *
     * @param Request     $request     request object
     * @param AuthorLogic $authorLogic AuthorLogic service
     *
     * @return Response
     *
     * @Route("/panel/add/author", name="addAuthor")
     */
    public function addAuthor(Request $request, AuthorLogic $authorLogic): Response
    {
        $form = $this->createForm(AddAuthorType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($authorLogic->addAuthor($task, $this->getDoctrine())) {
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
        return $this->render('panel/addAuthor.html.twig', array('form' => $form->createView(),));
    }

    /**
     * This method deleted author
     *
     * @param Request     $request     request object
     * @param int         $id          author id
     * @param AuthorLogic $authorLogic Authir Buisnesss
     *
     * @return Response
     *
     * @Route("/panel/del/author/{id}", name="delAuthor", requirements={"id": "\d+"})
     */
    public function delAuthor(Request $request, int $id, AuthorLogic $authorLogic): Response
    {
        $author = $authorLogic->getSingleAuthor($id, $this->getDoctrine());
        if ($author->getIdauthors() == null) {
            $this->addFlash(
                'danger',
                'Error!'
            );
            return $this->redirectToRoute('panel');
        }
        $books = $authorLogic->getAuthorBook($id, $this->getDoctrine());
        $authors = $authorLogic->getSingleAuthor(5, $this->getDoctrine());
        $authorLogic->removeAuthorBooks($authors, $books, $this->getDoctrine());
        if ($authorLogic->delAuthor($author, $this->getDoctrine())) {
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
     * This method edit author
     *
     * @param Request     $request     request object
     * @param int         $id          author id
     * @param AuthorLogic $authorLogic Authir Buisnesss
     *
     * @return Response
     *
     * @Route("/panel/edit/author/{id}", name="editAuthor", requirements={"id": "\d+"})
     */
    public function editAuthor(Request $request, int $id, AuthorLogic $authorLogic): Response
    {
        $author = $authorLogic->getSingleAuthor($id, $this->getDoctrine());
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
            if ($authorLogic->editAuthor($task, $this->getDoctrine())) {
                $this->addFlash(
                    'info',
                    'Your changes were saved!'
                );
            }
            return $this->redirectToRoute('homepage');
        }

        return $this->render('panel/addAuthor.html.twig', array('form' => $form->createView(),));
    }

    /**
     * This method get single author
     *
     * @param Request     $request     request object
     * @param int         $id          author id
     * @param AuthorLogic $authorLogic Authir Buisnesss
     *
     * @return Response
     *
     * @Route("/authors/{id}", name="singleAuthor", requirements={"id": "\d+"})
     */
    public function getSingleAuthor(Request $request, int $id, AuthorLogic $authorLogic): Response
    {
        $author = $authorLogic->getSingleAuthor($id, $this->getDoctrine());
        $books = $authorLogic->getAuthorBook($id, $this->getDoctrine());
        if (!$author) {
            $this->addFlash(
                'danger',
                'Error'
            );
            return $this->redirectToRoute('panel');
        }
        return $this->render('home/singleAuthor.html.twig', ['authors' => $author, 'books' => $books]);
    }

}
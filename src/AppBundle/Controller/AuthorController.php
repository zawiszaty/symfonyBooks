<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Form\AddAuthorType;
use AppBundle\Form\EditAuthorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends Controller
{
    /**
     * @Route("/authors", name="authors")
     * @Method("GET")
     */
    public function getAllAuthors(Request $request): Response
    {
        $repositoryAuthors = $this->getDoctrine()->getRepository(Authors::class);
        $authors = $repositoryAuthors->findAll();
        return $this->render('home/authors.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/panel/add/author", name="addAuthor")
     * @Method("GET")
     */
    public function addAuthor(Request $request): Response
    {
        $author = new Authors();
        $form = $this->createForm(AddAuthorType::class, $author);
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
        return $this->render('panel/addAuthor.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/panel/del/author/{id}", name="delAuthor", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function delAuthor(Request $request, int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Authors::class);
        $author = $repository->findOneByIdauthors($id);
        if ($author == null) {
            $this->addFlash('info', 'Author not found');
            return $this->redirectToRoute('panel');
        }
        if ($author->getIdauthors() == '5') {
            $this->addFlash(
                'info',
                'You can not delete this author!'
            );
            return $this->redirectToRoute('panel');
        }
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);
        $books = $repositoryBooks->findByauthorsauthors($id);
        $authors = $repository->findOneByIdauthors('5');
        $em = $this->getDoctrine()->getManager();
        foreach ($books as $item) {
            $item->setAuthorsauthors($authors);
        }
        $em->remove($author);
        $em->flush();
        $this->addFlash(
            'info',
            'Your changes were saved!'
        );
        return $this->redirectToRoute('panel');

    }

    /**
     * @Route("/panel/edit/author/{id}", name="editAuthor", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function editAuthor(Request $request, int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Authors::class);
        $author = $repository->findOneByIdauthors($id);
        if ($author == null) {
            $this->addFlash('notice', 'Author not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditAuthorType::class, $author);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            $this->addFlash(
                'info',
                'Your changes were saved!'
            );
            return $this->redirectToRoute('panel');
        }
        return $this->render('panel/addAuthor.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/authors/{id}", name="singleAuthor", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getSingleAuthor(Request $request, int $id): Response
    {
        $repositoryAuthors = $this->getDoctrine()->getRepository(Authors::class);
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);
        $authors = $repositoryAuthors->findOneByIdauthors($id);
        if ($authors == null) {
            $this->addFlash('notice', 'Author not found');
            return $this->redirectToRoute('authors');
        }
        $books = $repositoryBooks->findByAuthorsauthors($id);
        return $this->render('home/singleAuthor.html.twig', [
            'authors' => $authors,
            'books' => $books

        ]);
    }

}
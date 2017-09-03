<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Authors;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AuthorsController extends Controller
{
    /**
     * @Route("/authors", name="authors")
     */
    public function indexAction(Request $request)
    {
        $repositoryAuthors = $this->getDoctrine()->getRepository(Authors::class);


        $authors = $repositoryAuthors->findAll();


        return $this->render('home/authors.html.twig', [
            'authors' => $authors,


        ]);
    }
}

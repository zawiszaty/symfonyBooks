<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PanelController extends Controller
{
    /**
     * @Route("/panel", name="panel")
     */
    public function indexAction(Request $request)
    {
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);
        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
        $repositoryAuthors = $this->getDoctrine()->getRepository(Authors::class);
        $books = $repositoryBooks->findAll();
        $category = $repositoryCategory->findAll();
        $authors = $repositoryAuthors->findAll();


        // replace this example code with whatever you need
        return $this->render('panel/index.html.twig',[
            'books'=>$books,
            'category'=>$category,
            'authors'=>$authors,
        ]);
    }
}

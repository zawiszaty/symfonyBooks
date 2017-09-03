<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     */
    public function indexAction(Request $request)
    {
        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);


        $category = $repositoryCategory->findAll();


        return $this->render('home/category.html.twig', [
            'category' => $category,


        ]);
    }
}

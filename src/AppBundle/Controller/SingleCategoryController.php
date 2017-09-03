<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SingleCategoryController extends Controller
{
    /**
     * @Route("/category/{id}", name="singleCategory")
     */
    public function indexAction(Request $request, int $id)
    {


        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);

        $category = $repositoryCategory->findOneByIdcategory($id);
        if ($category == null) {
            $this->addFlash('info', 'Category not found');
            return $this->redirectToRoute('category');
        }
        $books = $repositoryBooks->findByCategorycategory($id);


        return $this->render('home/singleCategory.html.twig', [
            'category' => $category,
            'books' => $books

        ]);
    }
}

<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DelCategoryController extends Controller
{
    /**
     * @Route("/panel/del/category/{id}", name="delCategory")
     */
    public function indexAction(Request $request, int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneByIdcategory($id);
        if ($category == null) {
            $this->addFlash('notice', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        if($category->getIdcategory() == '5')
        {
            $this->addFlash('danger', 'You can not delete this category');
            return $this->redirectToRoute('panel');
        }
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);
        $books = $repositoryBooks->findByCategorycategory($id);
        $editCategory = $repository->findOneByIdcategory('5');
        foreach ($books as $item) {
            $item->setCategorycategory($editCategory);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
        $this->addFlash(
            'info',
            'Your changes were saved!'
        );
        return $this->redirectToRoute('panel');

    }
}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use AppBundle\Form\AddCategoryType;
use AppBundle\Form\EditCategoryType;
use AppBundle\Utils\CategoryLogic\AddCategory;
use AppBundle\Utils\CategoryLogic\DelCategory;
use AppBundle\Utils\CategoryLogic\EditCategory;
use AppBundle\Utils\CategoryLogic\GetAllCategory;
use AppBundle\Utils\CategoryLogic\GetCategoryBooks;
use AppBundle\Utils\CategoryLogic\GetSingleCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     */
    public function getAllCategory(Request $request, GetAllCategory $getAllCategory): Response
    {
        $category = $this->get(GetAllCategory::class)->getAllCategory($this->getDoctrine());
        return $this->render('home/category.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/category/{id}", name="singleCategory", requirements={"id": "\d+"})
     */
    public function getSingleCategory(Request $request, int $id, GetSingleCategory $getSingleCategory, GetCategoryBooks $getCategoryBooks): Response
    {
        $category = $this->get(GetSingleCategory::class)->getSingleCategory($id, $this->getDoctrine());
        $books = $this->get(GetCategoryBooks::class)->getCategoryBooks($id, $this->getDoctrine());
        if (!$category) {
            $this->addFlash('info', 'Category not found');
            return $this->redirectToRoute('category');
        }
        return $this->render('home/singleCategory.html.twig', [
            'category' => $category,
            'books' => $books

        ]);
    }

    /**
     * @Route("/panel/add/category", name="addCategory", requirements={"id": "\d+"})
     */
    public function addCategory(Request $request, AddCategory $addCategory): Response
    {
        $form = $this->createForm(AddCategoryType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(AddCategory::class)->addCategory($task, $this->getDoctrine())) {
                $this->addFlash(
                    'info',
                    'Your changes were saved!'
                );
            } else {
                $this->addFlash(
                    'error',
                    'error'
                );
            }
            return $this->redirectToRoute('panel');
        }
        return $this->render('panel/addCategory.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/panel/del/category/{id}", name="delCategory", requirements={"id": "\d+"})
     */
    public function delCategory(Request $request, int $id, DelCategory $delCategory, GetSingleCategory $getSingleCategory, GetCategoryBooks $getCategoryBooks): Response
    {
        $category = $this->get(GetSingleCategory::class)->getSingleCategory($id, $this->getDoctrine());
        if ($category->getIdcategory() == null) {

            $this->addFlash('danger', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        if ($category->getIdcategory() == '5') {
            $this->addFlash('danger', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        $books = $this->get(GetCategoryBooks::class)->getCategoryBooks($id, $this->getDoctrine());
        $editCategory = $this->get(GetSingleCategory::class)->getSingleCategory(5, $this->getDoctrine());
        foreach ($books as $item) {
            $item->setCategorycategory($editCategory);
        }
        if ($this->get(DelCategory::class)->delCategory($category, $this->getDoctrine())) {
            $this->addFlash(
                'info',
                'Your changes were saved!'
            );
        } else {
            $this->addFlash('danger', 'Error');
            return $this->redirectToRoute('panel');
        }
        return $this->redirectToRoute('panel');

    }

    /**
     * @Route("/panel/edit/category/{id}", name="editCategory", requirements={"id": "\d+"})
     */
    public function editCategory(Request $request, int $id, EditCategory $editCategory, GetSingleCategory $getSingleCategory): Response
    {
        $category = $this->get(GetSingleCategory::class)->getSingleCategory($id, $this->getDoctrine());
        if ($category->getIdcategory() == null) {
            $this->addFlash('danger', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditCategoryType::class, $category);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(EditCategory::class)->editategory($task, $this->getDoctrine())) {
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
        return $this->render('panel/addCategory.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

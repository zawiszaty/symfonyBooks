<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use AppBundle\Form\AddCategoryType;
use AppBundle\Form\EditCategoryType;
use AppBundle\Utils\CategoryLogic;
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
    public function getAllCategory(Request $request, CategoryLogic $categoryLogic): Response
    {
        $category = $this->get(CategoryLogic::class)->getAllCategory($this->getDoctrine());
        return $this->render('home/category.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/category/{id}", name="singleCategory", requirements={"id": "\d+"})
     */
    public function getSingleCategory(Request $request, int $id, CategoryLogic $categoryLogic): Response
    {
        $category = $this->get(CategoryLogic::class)->getSingleCategory($id, $this->getDoctrine());
        $books = $this->get(CategoryLogic::class)->getCategoryBooks($id, $this->getDoctrine());
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
    public function addCategory(Request $request, CategoryLogic $categoryLogic): Response
    {
        $form = $this->createForm(AddCategoryType::class);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(CategoryLogic::class)->addCategory($task, $this->getDoctrine())) {
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
    public function delCategory(Request $request, int $id, CategoryLogic $categoryLogic): Response
    {
        $delCategory = $this->get(CategoryLogic::class)->getSingleCategory($id, $this->getDoctrine());
        if ($delCategory->getIdcategory() == null) {
            $this->addFlash('danger', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        if ($delCategory->getIdcategory() == '5') {
            $this->addFlash('danger', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        $books = $this->get(CategoryLogic::class)->getCategoryBooks($id, $this->getDoctrine());
        $category = $this->get(CategoryLogic::class)->getSingleCategory(5, $this->getDoctrine());
        $this->get(CategoryLogic::class)->removeBooksCategory($category,$books, $this->getDoctrine());
        if ($this->get(CategoryLogic::class)->delCategory($delCategory, $this->getDoctrine())) {
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
     * @param Request $request
     * @param int $id
     * @param CategoryLogic $categoryLogic
     * @return Response
     */
    public function editCategory(Request $request, int $id, CategoryLogic $categoryLogic): Response
    {
        $category = $this->get(CategoryLogic::class)->getSingleCategory($id, $this->getDoctrine());
        if ($category->getIdcategory() == null) {
            $this->addFlash('danger', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditCategoryType::class, $category);
        $form->add('save', SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if ($this->get(CategoryLogic::class)->editategory($task, $this->getDoctrine())) {
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

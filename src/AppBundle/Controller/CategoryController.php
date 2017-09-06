<?php

namespace AppBundle\Controller;



use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use AppBundle\Form\AddCategoryType;
use AppBundle\Form\EditCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     * @Method("GET")
     */
    public function getAllCategory(Request $request): Response
    {
        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
        $category = $repositoryCategory->findAll();
        return $this->render('home/category.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/category/{id}", name="singleCategory", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function getSingleCategory(Request $request, int $id): Response
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

    /**
     * @Route("/panel/add/category", name="addCategory", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function addCategory(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(AddCategoryType::class, $category);
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
        return $this->render('panel/addCategory.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/panel/del/category/{id}", name="delCategory", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function delCategory(Request $request, int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneByIdcategory($id);
        if ($category == null) {
            $this->addFlash('notice', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        if ($category->getIdcategory() == '5') {
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

    /**
     * @Route("/panel/edit/category/{id}", name="editCategory", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function editCategory(Request $request, int $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneByIdcategory($id);
        if ($category == null) {
            $this->addFlash('notice', 'Category not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditCategoryType::class, $category);
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
        return $this->render('panel/addCategory.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

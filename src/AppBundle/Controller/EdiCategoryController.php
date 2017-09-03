<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\AddCategoryType;
use AppBundle\Form\EditCategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class EdiCategoryController extends Controller
{
    /**
     * @Route("/panel/edit/category/{id}", name="editCategory")
     */
    public function indexAction(Request $request, int $id)
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
        // replace this example code with whatever you need
        return $this->render('panel/addCategory.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Books;

use AppBundle\Form\EditBookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class EditBookController extends Controller
{
    /**
     * @Route("/panel/edit/book/{id}", name="editBook")
     */
    public function indexAction(Request $request, int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Books::class);
        $books = $repository->findOneByIdbooks($id);
        if ($books == null) {
            $this->addFlash('notice', 'Books not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditBookType::class, $books);
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


        return $this->render('panel/addBook.html.twig', array(
            'form' => $form->createView(),
        ));

    }
}

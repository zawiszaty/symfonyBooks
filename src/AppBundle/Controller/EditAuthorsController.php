<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Authors;
use AppBundle\Form\EditAuthorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class EditAuthorsController extends Controller
{
    /**
     * @Route("/panel/edit/author/{id}", name="editAuthor")
     */
    public function indexAction(Request $request, int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Authors::class);
        $author = $repository->findOneByIdauthors($id);
        if ($author==null)
        {
            $this->addFlash('notice','Author not found');
            return $this->redirectToRoute('panel');
        }
        $form = $this->createForm(EditAuthorType::class, $author);
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
        return $this->render('panel/addAuthor.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}

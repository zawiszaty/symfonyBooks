<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Books;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DelBookController extends Controller
{
    /**
     * @Route("/panel/del/book/{id}", name="delBook")
     */
    public function indexAction(Request $request, int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Books::class);
        $books = $repository->findOneByIdbooks($id);
        if ($books == null) {
            $this->addFlash('info', 'Book not found');
            return $this->redirectToRoute('panel');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($books);
        $em->flush();
        $this->addFlash(
            'info',
            'Your changes were saved!'
        );
        return $this->redirectToRoute('panel');

    }
}

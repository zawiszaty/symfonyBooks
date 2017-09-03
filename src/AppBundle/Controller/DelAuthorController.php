<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DelAuthorController extends Controller
{
    /**
     * @Route("/panel/del/author/{id}", name="delAuthor")
     */
    public function indexAction(Request $request, int $id)
    {
        $repository = $this->getDoctrine()->getRepository(Authors::class);
        $author = $repository->findOneByIdauthors($id);

        if ($author == null) {
            $this->addFlash('info', 'Author not found');
            return $this->redirectToRoute('panel');
        }
        if($author->getIdauthors() == '5')
        {
            $this->addFlash(
                'info',
                'You can not delete this author!'
            );
            return $this->redirectToRoute('panel');
        }
        $repositoryBooks = $this->getDoctrine()->getRepository(Books::class);

        $books = $repositoryBooks->findByauthorsauthors($id);

        $authors = $repository->findOneByIdauthors('5');
        $em = $this->getDoctrine()->getManager();
        foreach ($books as $item) {
            $item->setAuthorsauthors($authors);
        }
        $em->remove($author);
        $em->flush();
        $this->addFlash(
            'info',
            'Your changes were saved!'
        );
        return $this->redirectToRoute('panel');

    }
}

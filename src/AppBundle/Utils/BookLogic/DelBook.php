<?php

namespace AppBundle\Utils\BookLogic;

use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

class DelBook
{
    public function delBook(Books $books, Registry $doctrine): bool
    {
        if ($books->getIdbooks() == null) {

            return false;
        }
        $em = $doctrine->getManager();
        $em->remove($books);
        $em->flush();
        return true;
    }
}
<?php

namespace AppBundle\Utils\BookLogic;

use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;


class EditBook
{
    public function editBook(Books $books, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($books);
        $em->flush();
        return true;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 16:23
 */

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
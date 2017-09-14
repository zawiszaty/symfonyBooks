<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 09.09.2017
 * Time: 08:34
 */

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
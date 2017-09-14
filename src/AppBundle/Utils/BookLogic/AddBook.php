<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 09.09.2017
 * Time: 08:28
 */

namespace AppBundle\Utils\BookLogic;


use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

class AddBook
{
    public function addBook(Books $task, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return true;
    }
}
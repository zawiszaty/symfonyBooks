<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 09.09.2017
 * Time: 08:11
 */

namespace AppBundle\Utils\AuthorLogic;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\DependencyInjection\Container;

class AddAuthor
{
    public function addAuthor($task, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return true;
    }
}
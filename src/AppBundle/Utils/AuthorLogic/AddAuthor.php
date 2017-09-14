<?php

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
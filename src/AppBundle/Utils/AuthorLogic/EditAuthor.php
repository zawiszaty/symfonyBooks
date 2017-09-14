<?php

namespace AppBundle\Utils\AuthorLogic;

use AppBundle\Entity\Authors;
use Doctrine\Bundle\DoctrineBundle\Registry;

class EditAuthor
{
    public function editAuthor(Authors $task,Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return true;
    }

}
<?php

namespace AppBundle\Utils\AuthorLogic;

use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

class DelAuthor
{
    public function delAuthor(Authors $author, Registry $doctrine): bool
    {

        $em = $doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return true;
    }
}
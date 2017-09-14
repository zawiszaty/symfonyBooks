<?php

namespace AppBundle\Utils\AuthorLogic;

use AppBundle\Entity\Authors;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetAllAuthor
{
    public function getAllAuthors(Registry $doctrine): array
    {
        $repositoryAuthors = $doctrine->getRepository(Authors::class);
        $authors = $repositoryAuthors->findAll();
        return $authors;
    }
}
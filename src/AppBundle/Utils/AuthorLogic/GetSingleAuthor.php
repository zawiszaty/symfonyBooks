<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 19:09
 */

namespace AppBundle\Utils\AuthorLogic;


use AppBundle\Entity\Authors;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetSingleAuthor
{
    public function getSingleAuthor(int $id,Registry $doctrine): Authors
    {
        $repositoryAuthors = $doctrine->getRepository(Authors::class);
        $authors = $repositoryAuthors->findOneByIdauthors($id);
        if ($authors == null)
        {
            $authors = new Authors();
        }

        return $authors;
    }
}
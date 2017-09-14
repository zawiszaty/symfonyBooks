<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 19:16
 */

namespace AppBundle\Utils\AuthorLogic;


use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetAuthorBooks
{
    public function getAuthorBook(int $id, Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Books::class);
        $books = $repositoryBooks->findByAuthorsauthors($id);
        return $books;
    }
}
<?php

namespace AppBundle\Utils\BookLogic;

use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetSingleBook
{
    public function getSingleBook(int $id, Registry $doctrine): Books
    {
        $repositoryBooks = $doctrine->getRepository(Books::class);
        $book = $repositoryBooks->findOneByIdbooks($id);
        if (!$book) {
            $book = new Books();
        }
        return $book;
    }
}
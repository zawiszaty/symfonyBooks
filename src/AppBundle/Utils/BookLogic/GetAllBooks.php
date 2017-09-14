<?php

namespace AppBundle\Utils\BookLogic;


use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetAllBooks
{
    public function getAllBooks(Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Books::class);
        $books = $repositoryBooks->findAll();
        return $books;
    }
}
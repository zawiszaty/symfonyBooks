<?php

namespace AppBundle\Utils\CategoryLogic;

use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetCategoryBooks
{
    public function getCategoryBooks(int $id, Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Books::class);
        $books = $repositoryBooks->findByCategorycategory($id);
        if ($books == null) {
            $books = new Books();
        }
        return $books;
    }
}
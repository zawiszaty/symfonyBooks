<?php

namespace AppBundle\Utils;


use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

class CategoryLogic
{
    public function addCategory(Category $category, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($category);
        $em->flush();
        return true;
    }

    public function delCategory(Category $delCategory, Registry $doctrine): bool
    {

        $em = $doctrine->getManager();
        $em->remove($delCategory);
        $em->flush();
        return true;
    }

    public function editategory(Category $category, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($category);
        $em->flush();
        return true;
    }

    public function getAllCategory(Registry $doctrine): array
    {
        $repositoryCategory = $doctrine->getRepository(Category::class);
        $category = $repositoryCategory->findAll();
        return $category;
    }

    public function getCategoryBooks(int $id, Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Books::class);
        $books = $repositoryBooks->findByCategorycategory($id);

        return $books;
    }

    public function getSingleCategory(int $id, Registry $doctrine): Category
    {
        $repositoryCategory = $doctrine->getRepository(Category::class);
        $category = $repositoryCategory->findOneByIdcategory($id);
        if ($category == null) {
            $category = new Category();
        }
        return $category;
    }
    public function removeBooksCategory(Category $category, array $books, Registry $doctrine)
    {
        foreach ($books as $item) {
            $item->setCategorycategory($category);
        }
        $em = $doctrine->getManager();
        $em->flush();
        return true;
    }
}
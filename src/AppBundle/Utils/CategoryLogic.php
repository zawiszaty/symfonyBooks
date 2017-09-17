<?php

namespace AppBundle\Utils;


use AppBundle\Entity\Book;
use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class CategoryLogic
 * @package AppBundle\Utils
 */
class CategoryLogic
{
    /**
     * @param Category $category
     * @param Registry $doctrine
     * @return bool
     */
    public function addCategory(Category $category, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($category);
        $em->flush();
        return true;
    }

    /**
     * @param Category $delCategory
     * @param Registry $doctrine
     * @return bool
     */
    public function delCategory(Category $delCategory, Registry $doctrine): bool
    {

        $em = $doctrine->getManager();
        $em->remove($delCategory);
        $em->flush();
        return true;
    }

    /**
     * @param Category $category
     * @param Registry $doctrine
     * @return bool
     */
    public function editategory(Category $category, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($category);
        $em->flush();
        return true;
    }

    /**
     * @param Registry $doctrine
     * @return array
     */
    public function getAllCategory(Registry $doctrine): array
    {
        $repositoryCategory = $doctrine->getRepository(Category::class);
        $category = $repositoryCategory->findAll();
        return $category;
    }

    /**
     * @param int $id
     * @param Registry $doctrine
     * @return array
     */
    public function getCategoryBooks(int $id, Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Book::class);
        $books = $repositoryBooks->findByCategorycategory($id);

        return $books;
    }

    /**
     * @param int $id
     * @param Registry $doctrine
     * @return Category
     */
    public function getSingleCategory(int $id, Registry $doctrine): Category
    {
        $repositoryCategory = $doctrine->getRepository(Category::class);
        $category = $repositoryCategory->findOneByIdcategory($id);
        if ($category == null) {
            $category = new Category();
        }
        return $category;
    }

    /**
     * @param Category $category
     * @param array $books
     * @param Registry $doctrine
     * @return bool
     */
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
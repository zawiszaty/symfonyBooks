<?php

namespace AppBundle\Utils;


use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class BooksLogic
 * @package AppBundle\Utils
 */
class BooksLogic
{
    /**
     * @param Books $task
     * @param Registry $doctrine
     * @return bool
     */
    public function addBook(Books $task, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return true;
    }

    /**
     * @param Books $books
     * @param Registry $doctrine
     * @return bool
     */
    public function delBook(Books $books, Registry $doctrine): bool
    {
        if ($books->getIdbooks() == null) {

            return false;
        }
        $em = $doctrine->getManager();
        $em->remove($books);
        $em->flush();
        return true;
    }

    /**
     * @param Books $books
     * @param Registry $doctrine
     * @return bool
     */
    public function editBook(Books $books, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($books);
        $em->flush();
        return true;
    }

    /**
     * @param Registry $doctrine
     * @return array
     */
    public function getAllBooks(Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Books::class);
        $books = $repositoryBooks->findAll();
        return $books;
    }

    /**
     * @param int $id
     * @param Registry $doctrine
     * @return Books
     */
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
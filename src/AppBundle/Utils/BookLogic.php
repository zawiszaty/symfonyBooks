<?php

namespace AppBundle\Utils;


use AppBundle\Entity\Book;
use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class BooksLogic
 * @package AppBundle\Utils
 */
class BookLogic
{
    /**
     * @param Book $task
     * @param Registry $doctrine
     * @return bool
     */
    public function addBook(Book $task, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return true;
    }

    /**
     * @param Book $book
     * @param Registry $doctrine
     * @return bool
     */
    public function delBook(Book $book, Registry $doctrine): bool
    {
        if ($book->getIdbooks() == null) {

            return false;
        }
        $em = $doctrine->getManager();
        $em->remove($book);
        $em->flush();
        return true;
    }

    /**
     * @param Book $book
     * @param Registry $doctrine
     * @return bool
     */
    public function editBook(Book $book, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($book);
        $em->flush();
        return true;
    }

    /**
     * @param Registry $doctrine
     * @return array
     */
    public function getAllBooks(Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Book::class);
        $books = $repositoryBooks->findAll();
        return $books;
    }

    /**
     * @param int $id
     * @param Registry $doctrine
     * @return Book
     */
    public function getSingleBook(int $id, Registry $doctrine): Book
    {
        $repositoryBooks = $doctrine->getRepository(Book::class);
        $book = $repositoryBooks->findOneByIdbooks($id);
        if (!$book) {
            $book = new Book();
        }
        return $book;
    }



}
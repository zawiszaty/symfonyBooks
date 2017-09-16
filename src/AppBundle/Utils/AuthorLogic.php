<?php

namespace AppBundle\Utils;


use AppBundle\Entity\Authors;
use AppBundle\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class AuthorLogic
 * @package AppBundle\Utils
 */
class AuthorLogic
{
    /**
     *
     *
     * @param Authors  $task
     * @param Registry $doctrine
     * @return bool
     */
    public function addAuthor(Authors $task, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return true;
    }

    /**
     * @param Authors $author
     * @param Registry $doctrine
     * @return bool
     */
    public function delAuthor(Authors $author, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->remove($author);
        $em->flush();
        return true;
    }

    /**
     * @param Authors $task
     * @param Registry $doctrine
     * @return bool
     */
    public function editAuthor(Authors $task, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($task);
        $em->flush();
        return true;
    }

    /**
     * @param Registry $doctrine
     * @return array
     */
    public function getAllAuthors(Registry $doctrine): array
    {
        $repositoryAuthors = $doctrine->getRepository(Authors::class);
        $authors = $repositoryAuthors->findAll();
        return $authors;
    }

    /**
     * @param int $id
     * @param Registry $doctrine
     * @return array
     */
    public function getAuthorBook(int $id, Registry $doctrine): array
    {
        $repositoryBooks = $doctrine->getRepository(Books::class);
        $books = $repositoryBooks->findByAuthorsauthors($id);
        return $books;
    }

    /**
     * @param int $id
     * @param Registry $doctrine
     * @return Authors
     */
    public function getSingleAuthor(int $id, Registry $doctrine): Authors
    {
        $repositoryAuthors = $doctrine->getRepository(Authors::class);
        $authors = $repositoryAuthors->findOneByIdauthors($id);
        if ($authors == null) {
            $authors = new Authors();
        }

        return $authors;
    }

    /**
     * @param Authors $author
     * @param array $books
     * @param Registry $doctrine
     * @return bool
     */
    public function removeAuthorBooks(Authors $author, array $books, Registry $doctrine): bool
    {
        foreach ($books as $item) {
            $item->setAuthorsauthors($author);
        }
        $em = $doctrine->getManager();
        $em->flush();
        return true;
    }
}
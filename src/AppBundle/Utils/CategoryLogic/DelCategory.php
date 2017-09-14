<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 16:33
 */

namespace AppBundle\Utils\CategoryLogic;


use AppBundle\Entity\Books;
use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

class DelCategory
{
    public function delCategory(Category $category, Registry $doctrine): bool
    {

        $em = $doctrine->getManager();
        $em->remove($category);
        $em->flush();
        return true;
    }
}
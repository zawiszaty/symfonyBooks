<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 16:28
 */

namespace AppBundle\Utils\CategoryLogic;


use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

class AddCategory
{
    public function addCategory(Category $category, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($category);
        $em->flush();
        return true;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 16:38
 */

namespace AppBundle\Utils\CategoryLogic;



use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

class EditCategory
{
    public function editategory(Category $category, Registry $doctrine): bool
    {
        $em = $doctrine->getManager();
        $em->persist($category);
        $em->flush();
        return true;
    }
}
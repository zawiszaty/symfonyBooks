<?php

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
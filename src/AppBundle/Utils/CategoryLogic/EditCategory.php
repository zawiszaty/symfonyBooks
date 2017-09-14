<?php

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
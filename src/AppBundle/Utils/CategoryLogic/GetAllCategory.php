<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 19:39
 */

namespace AppBundle\Utils\CategoryLogic;


use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetAllCategory
{
    public function getAllCategory(Registry $doctrine): array
    {
        $repositoryCategory = $doctrine->getRepository(Category::class);
        $category = $repositoryCategory->findAll();
        return $category;
    }
}
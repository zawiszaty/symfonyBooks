<?php
/**
 * Created by PhpStorm.
 * User: zawisza
 * Date: 11.09.2017
 * Time: 19:43
 */

namespace AppBundle\Utils\CategoryLogic;


use AppBundle\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Registry;

class GetSingleCategory
{
    public function getSingleCategory(int $id, Registry $doctrine): Category
    {
        $repositoryCategory = $doctrine->getRepository(Category::class);
        $category = $repositoryCategory->findOneByIdcategory($id);
        if ($category == null) {
            $category = new Category();
        }
        return $category;
    }
}
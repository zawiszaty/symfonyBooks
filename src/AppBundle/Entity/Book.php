<?php

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Books
 *
 * @ORM\Table(name="books", indexes={@ORM\Index(name="fk_books_category_idx", columns={"category_idcategory"}), @ORM\Index(name="fk_books_authors1_idx", columns={"authors_idauthors"})})
 * @ORM\Entity
 * @UniqueEntity("name")
 */
class Book
{
    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     * @Assert\NotNull()
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="idbooks", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idbooks;

    /**
     * @var \AppBundle\Entity\Authors
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Authors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="authors_idauthors", referencedColumnName="idauthors")
     * })
     */
    private $authorsauthors;

    /**
     * @var \AppBundle\Entity\Category
     * @Assert\NotNull()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_idcategory", referencedColumnName="idcategory")
     * })
     */
    private $categorycategory;


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getIdbooks()
    {
        return $this->idbooks;
    }

    /**
     * @param int $idbooks
     */
    public function setIdbooks($idbooks)
    {
        $this->idbooks = $idbooks;
    }

    /**
     * @return Authors
     */
    public function getAuthorsauthors()
    {
        return $this->authorsauthors;
    }

    /**
     * @param Authors $authorsauthors
     */
    public function setAuthorsauthors($authorsauthors)
    {
        $this->authorsauthors = $authorsauthors;
    }

    /**
     * @return Category
     */
    public function getCategorycategory()
    {
        return $this->categorycategory;
    }

    /**
     * @param Category $categorycategory
     */
    public function setCategorycategory($categorycategory)
    {
        $this->categorycategory = $categorycategory;
    }


}


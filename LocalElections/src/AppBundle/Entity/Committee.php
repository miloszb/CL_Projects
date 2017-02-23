<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Committee
 *
 * @ORM\Table(name="committee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommitteeRepository")
 */
class Committee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="www_page", type="string", length=255, nullable=true)
     */
    private $wwwPage;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="ElectoralList", mappedBy="committee")
     */
    private $elLists;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Committee
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Committee
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set wwwPage
     *
     * @param string $wwwPage
     * @return Committee
     */
    public function setWwwPage($wwwPage)
    {
        $this->wwwPage = $wwwPage;

        return $this;
    }

    /**
     * Get wwwPage
     *
     * @return string 
     */
    public function getWwwPage()
    {
        return $this->wwwPage;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elLists = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add elLists
     *
     * @param \AppBundle\Entity\ElectoralList $elLists
     * @return Committee
     */
    public function addElList(\AppBundle\Entity\ElectoralList $elLists)
    {
        $this->elLists[] = $elLists;

        return $this;
    }

    /**
     * Remove elLists
     *
     * @param \AppBundle\Entity\ElectoralList $elLists
     */
    public function removeElList(\AppBundle\Entity\ElectoralList $elLists)
    {
        $this->elLists->removeElement($elLists);
    }

    /**
     * Get elLists
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElLists()
    {
        return $this->elLists;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Postcode
 *
 * @ORM\Table(name="postcode")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostcodeRepository")
 */
class Postcode
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
     * @ORM\Column(name="postcode", type="string", length=20, unique=true)
     */
    private $postcode;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ward", mappedBy="postcodes")
     */
    private $wards;

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
     * Set postcode
     *
     * @param string $postcode
     * @return Postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Postcode
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
     * Constructor
     */
    public function __construct()
    {
        $this->wards = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add wards
     *
     * @param \AppBundle\Entity\Ward $wards
     * @return Postcode
     */
    public function addWard(\AppBundle\Entity\Ward $wards)
    {
        $this->wards[] = $wards;

        return $this;
    }

    /**
     * Remove wards
     *
     * @param \AppBundle\Entity\Ward $wards
     */
    public function removeWard(\AppBundle\Entity\Ward $wards)
    {
        $this->wards->removeElement($wards);
    }

    /**
     * Get wards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWards()
    {
        return $this->wards;
    }

    public function sanitizePostcode()
    {
        $this->postcode = preg_replace('/[^\d]/', '', $this->postcode);
        return $this;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ward
 *
 * @ORM\Table(name="ward")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WardRepository")
 */
class Ward
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer", unique=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="annotation", type="string")
     */
    private $annotation;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Postcode", inversedBy="wards")
     * @ORM\JoinTable(name="postcode_ward")
     */
    private $postcodes;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\District", inversedBy="wards")
     * @ORM\JoinTable(name="ward_district")
     */
    private $districts;

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
     * Set number
     *
     * @param integer $number
     * @return Ward
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->postcodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->districts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Ward
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set annotation
     *
     * @param string $annotation
     * @return Ward
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;

        return $this;
    }

    /**
     * Get annotation
     *
     * @return string 
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Ward
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
     * Add postcodes
     *
     * @param \AppBundle\Entity\Postcode $postcodes
     * @return Ward
     */
    public function addPostcode(\AppBundle\Entity\Postcode $postcodes)
    {
        $this->postcodes[] = $postcodes;

        return $this;
    }

    /**
     * Remove postcodes
     *
     * @param \AppBundle\Entity\Postcode $postcodes
     */
    public function removePostcode(\AppBundle\Entity\Postcode $postcodes)
    {
        $this->postcodes->removeElement($postcodes);
    }

    /**
     * Get postcodes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPostcodes()
    {
        return $this->postcodes;
    }

    /**
     * Add districts
     *
     * @param \AppBundle\Entity\District $districts
     * @return Ward
     */
    public function addDistrict(\AppBundle\Entity\District $districts)
    {
        $this->districts[] = $districts;

        return $this;
    }

    /**
     * Remove districts
     *
     * @param \AppBundle\Entity\District $districts
     */
    public function removeDistrict(\AppBundle\Entity\District $districts)
    {
        $this->districts->removeElement($districts);
    }

    /**
     * Get districts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDistricts()
    {
        return $this->districts;
    }
}

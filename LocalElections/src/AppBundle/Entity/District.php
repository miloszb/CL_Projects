<?php

namespace AppBundle\Entity;

use AppBundle\Entity\ElectoralList;
use AppBundle\Entity\Ward;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * District
 *
 * @ORM\Table(name="district")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DistrictRepository")
 */
class District
{

    const QRT = 0;  // city quarter council
    const MNP = 1;  // municipal council
    const MA1 = 2;  // mayor - village
    const MA2 = 3;  // mayor - town
    const MA3 = 4;  // mayor - city
    const CNT = 5;  // county council
    const VOI = 6;  // voivodship council

    const NAMES = [
        self::QRT => 'Wybory do rady dzielnicy',
        self::MNP => 'Wybory do rady gminy',
        self::MA1 => 'Wybory wójta',
        self::MA2 => 'Wybory burmistrza',
        self::MA3 => 'Wybory prezydenta miasta',
        self::CNT => 'Wybory do rady powiatu',
        self::VOI => 'Wybory do sejmiku województwa',
    ];

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
     * @ORM\Column(name="locality", type="string")
     */
    private $locality;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    private $number;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ward", mappedBy="districts")
     */
    private $wards;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ElectoralList", mappedBy="district")
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
     * Set number
     *
     * @param integer $number
     * @return District
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
     * Set description
     *
     * @param string $description
     * @return District
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
     * Set level
     *
     * @param integer $level
     * @return District
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->wards = new ArrayCollection();
        $this->elLists = new ArrayCollection();
    }

    /**
     * Add wards
     *
     * @param Ward $wards
     * @return District
     */
    public function addWard(Ward $wards)
    {
        $this->wards[] = $wards;

        return $this;
    }

    /**
     * Remove wards
     *
     * @param Ward $wards
     */
    public function removeWard(Ward $wards)
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

    /**
     * Add elLists
     *
     * @param ElectoralList $elLists
     * @return District
     */
    public function addElList(ElectoralList $elLists)
    {
        $this->elLists[] = $elLists;

        return $this;
    }

    /**
     * Remove elLists
     *
     * @param ElectoralList $elLists
     */
    public function removeElList(ElectoralList $elLists)
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

    /**
     * @return array
     */
    public function getLevelNames()
    {
        return $this->levelNames;
    }

    /**
     * @return string
     */
    public function getLevelName()
    {
        return self::NAMES[$this->level];
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        $fullName = [];
        $fullName[] = $this->getLevelName();
        $fullName[] = $this->getLocality();
        if ($this->getNumber()) {
            $fullName[] = 'okręg wyborczy nr ' . $this->getNumber();
        }
        return implode(', ', $fullName);
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return District
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string 
     */
    public function getLocality()
    {
        return $this->locality;
    }
}

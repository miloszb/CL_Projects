<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidate
 *
 * @ORM\Table(name="candidate")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CandidateRepository")
 */
class Candidate
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * @var ElectoralList
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ElectoralList", inversedBy="candidates")
     * @ORM\JoinColumn(name="el_list_id", referencedColumnName="id")
     */
    private $elList;

    /**
     * @var int
     *
     * @ORM\Column(name="el_list_pos", type="integer", nullable=true)
     */
    private $elListPos;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="occupation", type="string", length=255)
     */
    private $occupation;

    /**
     * @var string
     *
     * @ORM\Column(name="domicile", type="string", length=255)
     */
    private $domicile;

    /**
     * @var string
     *
     * @ORM\Column(name="www_page", type="string", length=255, nullable=true)
     */
    private $wwwPage;

    /**
     * @var string
     *
     * @ORM\Column(name="www_info", type="string", length=255, nullable=true)
     */
    private $wwwInfo;

    /**
     * @var string
     *
     * @ORM\Column(name="www_history", type="string", length=255, nullable=true)
     */
    private $wwwHistory;


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
     * @return Candidate
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
     * Set surname
     *
     * @param string $surname
     * @return Candidate
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set elList
     *
     * @param integer $elList
     * @return Candidate
     */
    public function setElList($elList)
    {
        $this->elList = $elList;

        return $this;
    }

    /**
     * Get elList
     *
     * @return ElectoralList
     */
    public function getElList()
    {
        return $this->elList;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Candidate
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set occupation
     *
     * @param string $occupation
     * @return Candidate
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }

    /**
     * Get occupation
     *
     * @return string 
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * Set location
     *
     * @param string $domicile
     * @return Candidate
     */
    public function setDomicile($domicile)
    {
        $this->domicile = $domicile;

        return $this;
    }

    /**
     * Get location
     *
     * @return string 
     */
    public function getDomicile()
    {
        return $this->domicile;
    }

    /**
     * Set wwwPage
     *
     * @param string $wwwPage
     * @return Candidate
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
     * Set wwwInfo
     *
     * @param string $wwwInfo
     * @return Candidate
     */
    public function setWwwInfo($wwwInfo)
    {
        $this->wwwInfo = $wwwInfo;

        return $this;
    }

    /**
     * Get wwwInfo
     *
     * @return string 
     */
    public function getWwwInfo()
    {
        return $this->wwwInfo;
    }

    /**
     * Set wwwHistory
     *
     * @param string $wwwHistory
     * @return Candidate
     */
    public function setWwwHistory($wwwHistory)
    {
        $this->wwwHistory = $wwwHistory;

        return $this;
    }

    /**
     * Get wwwHistory
     *
     * @return string 
     */
    public function getWwwHistory()
    {
        return $this->wwwHistory;
    }

    /**
     * Set elListPos
     *
     * @param integer $elListPos
     * @return Candidate
     */
    public function setElListPos($elListPos)
    {
        $this->elListPos = $elListPos;

        return $this;
    }

    /**
     * Get elListPos
     *
     * @return integer 
     */
    public function getElListPos()
    {
        return $this->elListPos;
    }
}

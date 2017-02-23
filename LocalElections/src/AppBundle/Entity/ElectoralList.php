<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Candidate;
use AppBundle\Entity\Committee;
use AppBundle\Entity\District;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ElectoralList
 *
 * @ORM\Table(name="electoral_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ElectoralListRepository")
 */
class ElectoralList
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
     * @var District
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\District", inversedBy="elLists")
     */
    private $district;

    /**
     * @var Committee
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Committee", inversedBy="elLists")
     */
    private $committee;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Candidate", mappedBy="elList")
     */
    private $candidates;

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
     * Constructor
     */
    public function __construct()
    {
        $this->candidates = new ArrayCollection();
    }

    /**
     * Set district
     *
     * @param District $district
     * @return ElectoralList
     */
    public function setDistrict(District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return District
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set committee
     *
     * @param Committee $committee
     * @return ElectoralList
     */
    public function setCommittee(Committee $committee = null)
    {
        $this->committee = $committee;

        return $this;
    }

    /**
     * Get committee
     *
     * @return Committee
     */
    public function getCommittee()
    {
        return $this->committee;
    }

    /**
     * Add candidates
     *
     * @param Candidate $candidate
     * @return ElectoralList
     */
    public function addCandidate(Candidate $candidate)
    {
        $this->candidates[] = $candidate;

        return $this;
    }

    /**
     * Remove candidates
     *
     * @param Candidate $candidate
     */
    public function removeCandidate(Candidate $candidate)
    {
        $this->candidates->removeElement($candidate);
    }

    /**
     * Get candidates
     *
     * @return Collection
     */
    public function getCandidates()
    {
        return $this->candidates;
    }
}

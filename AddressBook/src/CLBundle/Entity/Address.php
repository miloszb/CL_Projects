<?php

namespace CLBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use CLBundle\Entity\Contact;

/**
 * Address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="CLBundle\Repository\AddressRepository")
 */
class Address
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
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="house_no", type="string", length=40, nullable=true)
     */
    private $houseNo;

    /**
     * @var string
     *
     * @ORM\Column(name="appt_no", type="string", length=40, nullable=true)
     */
    private $apptNo;

    /**
     * @ORM\ManyToOne(targetEntity="CLBundle\Entity\Contact", inversedBy="addresses")
     */
    private $contact;

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
     * Set city
     *
     * @param string $city
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set houseNo
     *
     * @param string $houseNo
     * @return Address
     */
    public function setHouseNo($houseNo)
    {
        $this->houseNo = $houseNo;

        return $this;
    }

    /**
     * Get houseNo
     *
     * @return string
     */
    public function getHouseNo()
    {
        return $this->houseNo;
    }

    /**
     * Set apptNo
     *
     * @param string $apptNo
     * @return Address
     */
    public function setApptNo($apptNo)
    {
        $this->apptNo = $apptNo;

        return $this;
    }

    /**
     * Get apptNo
     *
     * @return string
     */
    public function getApptNo()
    {
        return $this->apptNo;
    }

    /**
     * Set contact
     *
     * @param Contact $contact
     * @return Address
     */
    public function setContact(Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }
}

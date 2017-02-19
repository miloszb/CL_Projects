<?php

namespace CLBundle\Entity;

use CLBundle\Entity\Address;
use CLBundle\Entity\CGroup;
use CLBundle\Entity\Email;
use CLBundle\Entity\Phone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="CLBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=100, nullable=true)
     */
    private $surname;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CLBundle\Entity\Address", mappedBy="contact");
     */
    private $addresses;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CLBundle\Entity\Email", mappedBy="contact");
     */
    private $emails;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CLBundle\Entity\Phone", mappedBy="contact");
     */
    private $phones;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CLBundle\Entity\CGroup", inversedBy="contacts");
     * @ORM\JoinTable(name="cgroup_contact",
     *     joinColumns={@ORM\JoinColumn(name="contact_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="cgroup_id", referencedColumnName="id")}
     *     )
     */
    private $groups;

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
     * @return Contact
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
     * @return Contact
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
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
    }

    /**
     * Add addresses
     *
     * @param Address $address
     * @return Contact
     */
    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param Address $address
     */
    public function removeAddress(Address $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add emails
     *
     * @param Email $email
     * @return Contact
     */
    public function addEmail(Email $email)
    {
        $this->emails[] = $email;

        return $this;
    }

    /**
     * Remove emails
     *
     * @param Email $emails
     */
    public function removeEmail(Email $emails)
    {
        $this->emails->removeElement($emails);
    }

    /**
     * Get emails
     *
     * @return ArrayCollection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add phones
     *
     * @param Phone $phone
     * @return Contact
     */
    public function addPhone(Phone $phone)
    {
        $this->phones[] = $phone;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param Phone $phone
     */
    public function removePhone(Phone $phone)
    {
        $this->phones->removeElement($phone);
    }

    /**
     * Get phones
     *
     * @return ArrayCollection
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Add groups
     *
     * @param CGroup $group
     * @return Contact
     */
    public function addGroup(CGroup $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param CGroup $group
     */
    public function removeGroup(CGroup $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getGroups()
    {
        return $this->groups;
    }
}

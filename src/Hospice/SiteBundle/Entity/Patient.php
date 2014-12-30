<?php

namespace Hospice\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Patient
 */
class Patient
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $pesel;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $address;

    /**
     * @var integer
     */
    private $age;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $volunteers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->volunteers = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set pesel
     *
     * @param string $pesel
     * @return Patient
     */
    public function setPesel($pesel)
    {
        $this->pesel = $pesel;

        return $this;
    }

    /**
     * Get pesel
     *
     * @return string 
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Patient
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
     * Set lastname
     *
     * @param string $lastname
     * @return Patient
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Patient
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
     * Set age
     *
     * @param integer $age
     * @return Patient
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
     * Add volunteers
     *
     * @param \Hospice\SiteBundle\Entity\Volunteer $volunteers
     * @return Patient
     */
    public function addVolunteer(\Hospice\SiteBundle\Entity\Volunteer $volunteers)
    {
        $this->volunteers[] = $volunteers;

        return $this;
    }

    /**
     * Remove volunteers
     *
     * @param \Hospice\SiteBundle\Entity\Volunteer $volunteers
     */
    public function removeVolunteer(\Hospice\SiteBundle\Entity\Volunteer $volunteers)
    {
        $this->volunteers->removeElement($volunteers);
    }

    /**
     * Get volunteers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVolunteers()
    {
        return $this->volunteers;
    }
    public function __toString()
    {
        return $this->getLastname() . " " . $this->getName();
    }
    public function toJSON()
    {
    	$json = array();
    	$json['id'] = $this->getId();
    	$json['pesel'] = $this->getPesel();
    	$json['name'] = $this->getName();
    	$json['lastname'] = $this->getName();
    	$json['address'] = $this->getAge();
    	$json['age'] = $this->getAddress();
    	return json_encode($json);
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $events;


    /**
     * Add events
     *
     * @param \Hospice\SiteBundle\Entity\Event $events
     * @return Patient
     */
    public function addEvent(\Hospice\SiteBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \Hospice\SiteBundle\Entity\Event $events
     */
    public function removeEvent(\Hospice\SiteBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }
}

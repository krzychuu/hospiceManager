<?php

namespace Hospice\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Volunteer
 */
class Volunteer
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
     * @var string
     */
    private $mail;

    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $patients;

    /**
     * @var \DateTime
     */
    private $birth_date;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var integer
     */
    private $type;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->patients = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Volunteer
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
     * @return Volunteer
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
     * @return Volunteer
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
     * @return Volunteer
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
     * Set mail
     *
     * @param string $mail
     * @return Volunteer
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Add patients
     *
     * @param \Hospice\SiteBundle\Entity\Patient $patients
     * @return Volunteer
     */
    public function addPatient(\Hospice\SiteBundle\Entity\Patient $patients)
    {
        $this->patients[] = $patients;

        return $this;
    }

    /**
     * Remove patients
     *
     * @param \Hospice\SiteBundle\Entity\Patient $patients
     */
    public function removePatient(\Hospice\SiteBundle\Entity\Patient $patients)
    {
        $this->patients->removeElement($patients);
    }

    /**
     * Get patients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPatients()
    {
        return $this->patients;
    }

    public function __toString()
    {
        return $this->getName();
    }
    public function toJSON()
    {
    	$json = array();
    	$json['id'] = $this->getId();
    	$json['pesel'] = $this->getPesel();
    	$json['name'] = $this->getName();
    	$json['lastname'] = $this->getName();
    	$json['street'] = $this->getStreet();
    	$json['city'] = $this->getCity();
    	$json['phone'] = $this->getPhone();
    	$json['mail'] = $this->getMail();
    	return json_encode($json);
    }


    /**
     * Set birth_date
     *
     * @param \DateTime $birthDate
     * @return Volunteer
     */
    public function setBirthDate($birthDate)
    {
        $this->birth_date = $birthDate;

        return $this;
    }

    /**
     * Get birth_date
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Volunteer
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
     * Set city
     *
     * @param string $city
     * @return Volunteer
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
     * Set phone
     *
     * @param string $phone
     * @return Volunteer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Volunteer
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
}

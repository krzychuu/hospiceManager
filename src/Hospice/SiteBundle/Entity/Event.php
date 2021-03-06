<?php

namespace Hospice\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 */
class Event
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $type;


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
     * Set type
     *
     * @param integer $type
     * @return Event
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
    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $stop;


    /**
     * Set start
     *
     * @param \DateTime $start
     * @return Event
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;


    /**
     * Set name
     *
     * @param string $name
     * @return Event
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
     * @return Event
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
     * @var \DateTime
     */
    private $end;


    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Event
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }
    /**
     * @var \Hospice\SiteBundle\Entity\EventRecur
     */
    private $recurOptions;


    /**
     * Set recurOptions
     *
     * @param \Hospice\SiteBundle\Entity\EventRecur $recurOptions
     * @return Event
     */
    public function setRecurOptions(\Hospice\SiteBundle\Entity\EventRecur $recurOptions = null)
    {
        $this->recurOptions = $recurOptions;

        return $this;
    }

    /**
     * Get recurOptions
     *
     * @return \Hospice\SiteBundle\Entity\EventRecur 
     */
    public function getRecurOptions()
    {
        return $this->recurOptions;
    }

    public function __toString()
    {
        return $this->getName();
    }
    public function toJSON()
    {
    	$json = array();
    	$json['id'] = $this->getId();
    	$json['title'] = $this->getName();
    	$json['description'] = $this->getDescription();
    	$json['type'] = $this->getType();
        $dt = $this->getStart();
        $json['start'] = $dt ? $dt->format("Y-m-d\TH:i:s") : null;
        $dt = $this->getEnd();
    	$json['end'] = $dt ? $dt->format("Y-m-d\TH:i:s") : null;

    	return json_encode($json);
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $patients;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $volunteers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->patients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->volunteers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add patients
     *
     * @param \Hospice\SiteBundle\Entity\Patient $patients
     * @return Event
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

    /**
     * Add volunteers
     *
     * @param \Hospice\SiteBundle\Entity\Volunteer $volunteers
     * @return Event
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
}

<?php

namespace Hospice\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Frequency
 */
class Frequency
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;


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
     * @return Frequency
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

    public function __toString()
    {
        return $this->getName();
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $intervalOptions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->intervalOptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add intervalOptions
     *
     * @param \Hospice\SiteBundle\Entity\IntervalOption $intervalOptions
     * @return Frequency
     */
    public function addIntervalOption(\Hospice\SiteBundle\Entity\IntervalOption $intervalOptions)
    {
        $this->intervalOptions[] = $intervalOptions;

        return $this;
    }

    /**
     * Remove intervalOptions
     *
     * @param \Hospice\SiteBundle\Entity\IntervalOption $intervalOptions
     */
    public function removeIntervalOption(\Hospice\SiteBundle\Entity\IntervalOption $intervalOptions)
    {
        $this->intervalOptions->removeElement($intervalOptions);
    }

    /**
     * Get intervalOptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIntervalOptions()
    {
        return $this->intervalOptions;
    }
}

<?php

namespace Hospice\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IntervalOption
 */
class IntervalOption
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
     * @var integer
     */
    private $value;


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
     * @return IntervalOption
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
     * Set value
     *
     * @param integer $value
     * @return IntervalOption
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @var \Hospice\SiteBundle\Entity\Frequency
     */
    private $frequency;


    /**
     * Set frequency
     *
     * @param \Hospice\SiteBundle\Entity\Frequency $frequency
     * @return IntervalOption
     */
    public function setFrequency(\Hospice\SiteBundle\Entity\Frequency $frequency = null)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return \Hospice\SiteBundle\Entity\Frequency 
     */
    public function getFrequency()
    {
        return $this->frequency;
    }
}

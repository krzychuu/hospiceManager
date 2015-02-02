<?php

namespace Hospice\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventRecur
 */
class EventRecur
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $interval;

    /**
     * @var integer
     */
    private $intervalFlags;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var \Hospice\SiteBundle\Entity\Event
     */
    private $event;

    /**
     * @var \Hospice\SiteBundle\Entity\Frequency
     */
    private $frequency;

    /**
     * @var \Hospice\SiteBundle\Entity\EventRecur
     */
    private $parent;


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
     * Set interval
     *
     * @param integer $interval
     * @return EventRecur
     */
    public function setInterval($interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * Get interval
     *
     * @return integer 
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * Set intervalFlags
     *
     * @param integer $intervalFlags
     * @return EventRecur
     */
    public function setIntervalFlags($intervalFlags)
    {
        $this->intervalFlags = $intervalFlags;

        return $this;
    }

    /**
     * Get intervalFlags
     *
     * @return integer 
     */
    public function getIntervalFlags()
    {
        return $this->intervalFlags;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return EventRecur
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
     * Set event
     *
     * @param \Hospice\SiteBundle\Entity\Event $event
     * @return EventRecur
     */
    public function setEvent(\Hospice\SiteBundle\Entity\Event $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \Hospice\SiteBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set frequency
     *
     * @param \Hospice\SiteBundle\Entity\Frequency $frequency
     * @return EventRecur
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

    /**
     * Set parent
     *
     * @param \Hospice\SiteBundle\Entity\EventRecur $parent
     * @return EventRecur
     */
    public function setParent(\Hospice\SiteBundle\Entity\EventRecur $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Hospice\SiteBundle\Entity\EventRecur 
     */
    public function getParent()
    {
        return $this->parent;
    }
    public function __toString()
    {
        return "recurOption";
    }

}

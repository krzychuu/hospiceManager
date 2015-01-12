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
    private $flags;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var \Hospice\SiteBundle\Entity\Frequency
     */
    private $frequency;


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
     * Set flags
     *
     * @param integer $flags
     * @return EventRecur
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Get flags
     *
     * @return integer 
     */
    public function getFlags()
    {
        return $this->flags;
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
     * @var \Hospice\SiteBundle\Entity\Event
     */
    private $event_id;

    /**
     * @var \Hospice\SiteBundle\Entity\EventRecur
     */
    private $parent;


    /**
     * Set event_id
     *
     * @param \Hospice\SiteBundle\Entity\Event $eventId
     * @return EventRecur
     */
    public function setEventId(\Hospice\SiteBundle\Entity\Event $eventId = null)
    {
        $this->event_id = $eventId;

        return $this;
    }

    /**
     * Get event_id
     *
     * @return \Hospice\SiteBundle\Entity\Event 
     */
    public function getEventId()
    {
        return $this->event_id;
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
    /**
     * @var \Hospice\SiteBundle\Entity\Event
     */
    private $event;


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

    public function __toString()
    {
        return strval($this->getId()) . " oryginalEvent=" . $this->getEvent();
    }

}

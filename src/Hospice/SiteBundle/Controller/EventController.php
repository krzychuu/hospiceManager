<?php

namespace Hospice\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Hospice\SiteBundle\Entity\Event;
use Hospice\SiteBundle\Entity\EventRecur;
use Hospice\SiteBundle\Entity\Frequency;
use Hospice\SiteBundle\Entity\IntervalOption;
use Hospice\SiteBundle\Form\EventType;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{
    const DAY_MONDAY = 1;
    const DAY_TUSEDAY = 2;
    const DAY_WEDNESDAY = 3;
    const DAY_THURSDAY = 4;
    const DAY_FRIDAY = 5;
    const DAY_SATURDAY = 6;
    const DAY_SUNDAY = 7;
    /**
     * Lists all Event entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HospiceSiteBundle:Event')->findAll();
        $entity = new Event();
        $form = $this->createCreateForm($entity);

    	$query = $em->getRepository('HospiceSiteBundle:IntervalOption')->createQueryBuilder('i')
                    ->join('i.frequency', 'f')
    		        ->getQuery();
    	$frequencies = $em->getRepository('HospiceSiteBundle:Frequency')->findAll();
        
        $freqAndIntervalOptArray = array();
        foreach ($frequencies as $f) 
        {
            $a = array();
            $a["id"] = $f->getId();
            $a["name"] = $f->getName();
            $opts = array();
            $intervalOpts = $f->getIntervalOptions();
            foreach ($intervalOpts as $i) 
            {
                $opt = array();
                $opt["name"] = $i->getName();
                $opt["value"] = $i->getValue();
                array_push($opts, $opt);
            }
            $a["opts"] = $opts;
            array_push($freqAndIntervalOptArray, $a);
        }

        return $this->render('HospiceSiteBundle:Event:index.html.twig', array(
            'entities' => $entities,
            'frequencies' => json_encode($freqAndIntervalOptArray),
            'form'   => $form->createView(),
        ));
    }

    private function getPerDayOptions($freq) {
        $opts = $freq->getIntervalOptions();
        $opts_array = array();
        foreach ($opts as $o) {
            $opts_array[$o->getName()] = $o;
        }
        return $opts_array;
    }

    private function createEvent($orygEvent, $interval) {
        $dateStep = new \DateInterval("P0D");
        $dateStep->d = $interval;
        $e = clone $orygEvent;
        $start = clone $e->getStart();
        $end = clone $e->getEnd();
        
        $start->add($dateStep);
        $end->add($dateStep);
        $e->setStart($start);
        $e->setEnd($end);
        return $e;
    }

    private function getEventsSeriesStart($dateStart, $event) {
        $r = $event->getRecurOptions();
        $name = $r->getFrequency()->getName();


        $e = null;
        $dateStep = new \DateInterval("P0D");
        if ($dateStart > $event->getEnd()) { //todo check repeating end
            $dateDiff = date_diff($event->getStart(), $dateStart);
            $interval = $r->getInterval();
            if ($name === 'PER_DAY') {
                $step = intval(($dateDiff->days + $interval - 1) / $interval) * $interval;
                $dateStep->d = $step;
            } elseif ($name === 'PER_WEEK') {
                $interval = $interval * 7;
                $step = intval(($dateDiff->days + $interval - 1) / $interval) * $interval;
                $dateStep->d = $step;
            } elseif ($name === 'PER_MONTH') {
                $m = $dateDiff->m;
                if ($dateDiff->d > 0) {
                    $m += 1;
                }
                $dateStep->m = intval(($m + $interval - 1) / $interval) * $interval;
            } elseif ($name === 'PER_YEAR') {
                $y = $dateDiff->y;
                if ($dateDiff->m > 0 || $dateDiff->d > 0) {
                    $y += 1;
                }
                $dateStep->y = intval(($y + $interval - 1) / $interval) * $interval;
            }
            $e = clone $event;
            $e->setStart(clone $event->getStart());
            $e->setEnd(clone $event->getEnd());
            $e->getStart()->add($dateStep);
            $e->getEnd()->add($dateStep);
        } else {
            $e = clone $event;
            $e->setStart(clone $event->getStart());
            $e->setEnd(clone $event->getEnd());
        }
        return $e;
    }

    /**
     * Lists all Event entities.
     *
     */
    public function getEventsAction($start, $repeatingEnd)
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('HospiceSiteBundle:Event')->findAllBetweenStartAndRepeatingEndDate($start, $repeatingEnd);
     	$response = new JsonResponse();
    
    	$jsonArray = array();
    
    	foreach ($events as $event) {
            $dateDiff = null;
            $r = $event->getRecurOptions();
            if ($r != null) {
                $firstEventStart;
                $dateStart = new \DateTime($start);
                $dateEnd = new \DateTime($repeatingEnd);
                $dateStep = new \DateInterval("P0D");
                $dateDiff = date_diff($event->getStart(), $dateStart);

                $name = $r->getFrequency()->getName();
                if ($name === 'PER_DAY') {
                    if ($r->getInterval() > 0) {
                        $e = $this->getEventsSeriesStart($dateStart, $event);
                        $dateStep->d = $r->getInterval();
                        while ($e->getStart() < $dateEnd) {
        	                array_push($jsonArray, $e->toJSON());
                            $e->getStart()->add($dateStep);
                            $e->getEnd()->add($dateStep);
                        }
                    }
                } elseif ($name === 'PER_WEEK') {
                    if ($r->getInterval() > 0) {
                        $firstEventInWeek = $this->getEventsSeriesStart($dateStart, $event);

                        $eventInWeek = array();
                        $flags = intval($r->getIntervalFlags());
                        if ($flags != 0) {
                            $opts_arr = $this->getPerDayOptions($r->getFrequency());
                            $dateStep->d = intval($firstEventInWeek->getStart()->format("N")) - self::DAY_MONDAY;
                            $firstEventInWeek->getStart()->sub($dateStep);
                            $firstEventInWeek->getEnd()->sub($dateStep);
                            if ($flags & $opts_arr["ON_MONDAY"]->getValue()) {
                                $e = $this->createEvent($firstEventInWeek, 0);
                                array_push($eventInWeek, $e);
                            }
                            if ($flags & $opts_arr["ON_TUSEDAY"]->getValue()) {
                                $e = $this->createEvent($firstEventInWeek, 1);
                                array_push($eventInWeek, $e);
                            }
                            if ($flags & $opts_arr["ON_WEDNESDAY"]->getValue()) {
                                $e = $this->createEvent($firstEventInWeek, 2);
                                array_push($eventInWeek, $e);
                            }
                            if ($flags & $opts_arr["ON_THURSDAY"]->getValue()) {
                                $e = $this->createEvent($firstEventInWeek, 3);
                                array_push($eventInWeek, $e);
                            }
                            if ($flags & $opts_arr["ON_FRIDAY"]->getValue()) {
                                $e = $this->createEvent($firstEventInWeek, 4);
                                array_push($eventInWeek, $e);
                            }
                            if ($flags & $opts_arr["ON_SATURDAY"]->getValue()) {
                                $e = $this->createEvent($firstEventInWeek, 5);
                                array_push($eventInWeek, $e);
                            }
                            if ($flags & $opts_arr["ON_SUNDAY"]->getValue()) {
                                $e = $this->createEvent($firstEventInWeek, 6);
                                array_push($eventInWeek, $e);
                            }
                        } else {
                            $e = /* clone */ $firstEventInWeek;
                            array_push($eventInWeek, $e);
                        }

                        $dateStep->d = $r->getInterval() * 7;

                        $contFlag = true;
                        while ($contFlag) {
    	                    foreach ($eventInWeek as $e) {
                                if ($e->getStart() > $dateEnd) {
                                    $contFlag = false;
                                    break;
                                }
                                if ($e->getEnd() >= $dateStart) {
                                    array_push($jsonArray, $e->toJSON());
                                }
                                $e->getStart()->add($dateStep);
                                $e->getEnd()->add($dateStep);
                            }
                        }
                    }
                } elseif ($name === 'PER_MONTH') {
                    $e = $this->getEventsSeriesStart($dateStart, $event);
                    $dateStep->m = $r->getInterval();
                    while ($e->getStart() < $dateEnd) {
                        array_push($jsonArray, $e->toJSON());
                        $e->getStart()->add($dateStep);
                        $e->getEnd()->add($dateStep);
                    }
                } elseif ($name === 'PER_YEAR') {
                    $e = $this->getEventsSeriesStart($dateStart, $event);
                    $dateStep->y = $r->getInterval();
                    while ($e->getStart() < $dateEnd) {
                        array_push($jsonArray, $e->toJSON());
                        $e->getStart()->add($dateStep);
                        $e->getEnd()->add($dateStep);
                    }
                }
            } else {
        	    array_push($jsonArray, $event->toJSON());
            }
    	}
    	$response->setData($jsonArray);
    	$response->setStatusCode(Response::HTTP_OK);
    	return $response;

    }

    /**
     * Creates a new Event entity.
     *
     */
    public function createAction(Request $request)
    {
        $event = new Event();

        $form = $this->createCreateForm($event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $recurOptions = $event->getRecurOptions();
            $recuOptionsExists = ($recurOptions->getFrequency() != null);
            $em = $this->getDoctrine()->getManager();
            if ($recuOptionsExists) {
                $recurOptions->setEvent($event);
            } else {
                $event->setRecurOptions(null);
            }
            $em->persist($event);
            if ($recuOptionsExists) {
                $em->persist($recurOptions);
            }
            $em->flush();

            return $this->redirect($this->generateUrl('event'));
        }

        return $this->render('HospiceSiteBundle:Event:new.html.twig', array(
            'entity' => $event,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Event entity.
    *
    * @param Event $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Event $entity)
    {
        $eventType = new EventType();
        $form = $this->createForm($eventType, $entity, array(
            'attr' => ['id' => $eventType->getName() . "_id"],
            'action' => $this->generateUrl('event_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Event entity.
     *
     */
    public function newAction()
    {
        $entity = new Event();
        $form   = $this->createCreateForm($entity);

        return $this->render('HospiceSiteBundle:Event:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Event entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HospiceSiteBundle:Event:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Event entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HospiceSiteBundle:Event:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Event entity.
    *
    * @param Event $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Event $entity)
    {
        $form = $this->createForm(new EventType(), $entity, array(
            'action' => $this->generateUrl('event_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Event entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Event')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Event entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $recurOptions = $entity->getRecurOptions();
            $recuOptionsExists = ($recurOptions->getFrequency() != null);
            if ($recuOptionsExists) {
                $recurOptions->setEvent($entity);
            } else {
                $entity->setRecurOptions(null);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('event_edit', array('id' => $id)));
        }

        return $this->render('HospiceSiteBundle:Event:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Event entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HospiceSiteBundle:Event')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Event entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('event'));
    }

    /**
     * Creates a form to delete a Event entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

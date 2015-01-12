<?php

namespace Hospice\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Hospice\SiteBundle\Entity\Event;
use Hospice\SiteBundle\Entity\EventRecur;
use Hospice\SiteBundle\Form\EventType;

/**
 * Event controller.
 *
 */
class EventController extends Controller
{

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

        $eventRecur = new EventRecur();

        return $this->render('HospiceSiteBundle:Event:index.html.twig', array(
            'entities' => $entities,
            'form'   => $form->createView(),
        ));
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
    		$jsonArray[] = $event->toJSON();
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

            return $this->redirect($this->generateUrl('event_show', array('id' => $event->getId())));
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

        $form->add('submit', 'submit', array('label' => 'Create'));
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

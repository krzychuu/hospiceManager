<?php

namespace Hospice\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Hospice\SiteBundle\Entity\Volunteer;
use Hospice\SiteBundle\Form\VolunteerType;

/**
 * Volunteer controller.
 *
 */
class VolunteerController extends Controller
{

    /**
     * Lists all Volunteer entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HospiceSiteBundle:Volunteer')->findAll();

        $entity = new Volunteer();
        $form = $this->createCreateForm($entity);
        return $this->render('HospiceSiteBundle:Volunteer:index.html.twig', array(
            'entities' => $entities,
            'form'   => $form->createView()
        ));
    }
    /**
     * Lists all Volunteers entities.
     *
     */
    public function getJSONEntitiesAction($queryString)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	if ($queryString == null || $queryString == "") {
    		$entities = $em->getRepository('HospiceSiteBundle:Volunteer')->findAll();
    	} else {
    		$query = $em->getRepository('HospiceSiteBundle:Volunteer')->createQueryBuilder('v')
    		->where('v.name LIKE :query')
    		->orWhere('v.lastname LIKE :query')
    		->orWhere('v.pesel LIKE :query')
    		->orWhere('v.address LIKE :query')
    		->setParameter('query', '%' . $queryString . '%')
    		->getQuery();
    		$entities = $query->getResult();;
    	}
    	$response = new JsonResponse();
    
    	$jsonArray = array();
    
    	foreach ($entities as $entity) {
    		$jsonArray[] = $entity->toJSON();
    	}
    	$response->setData($jsonArray);
    	$response->setStatusCode(Response::HTTP_OK);
    	return $response;
    }

    /**
     * Creates a new Volunteer entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Volunteer();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('volunteer'));
        }

        return $this->render('HospiceSiteBundle:Volunteer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Volunteer entity.
    *
    * @param Volunteer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Volunteer $entity)
    {
        $volunteerType = new VolunteerType();
        $form = $this->createForm($volunteerType, $entity, array(
            'attr' => ['id' => $volunteerType->getName() . "_id"],
            'action' => $this->generateUrl('volunteer_create'),
            'method' => 'POST',
        ));

//        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Volunteer entity.
     *
     */
    public function newAction()
    {
        $entity = new Volunteer();
        $form   = $this->createCreateForm($entity);

        return $this->render('HospiceSiteBundle:Volunteer:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Volunteer entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Volunteer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Volunteer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HospiceSiteBundle:Volunteer:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Volunteer entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Volunteer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Volunteer entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HospiceSiteBundle:Volunteer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Volunteer entity.
    *
    * @param Volunteer $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Volunteer $entity)
    {
        $form = $this->createForm(new VolunteerType(), $entity, array(
            'action' => $this->generateUrl('volunteer_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Volunteer entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Volunteer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Volunteer entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('volunteer_edit', array('id' => $id)));
        }

        return $this->render('HospiceSiteBundle:Volunteer:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Volunteer entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HospiceSiteBundle:Volunteer')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Volunteer entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('volunteer'));
    }

    /**
     * Creates a form to delete a Volunteer entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('volunteer_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

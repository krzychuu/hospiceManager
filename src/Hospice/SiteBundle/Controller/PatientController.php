<?php

namespace Hospice\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Hospice\SiteBundle\Entity\Patient;
use Hospice\SiteBundle\Form\PatientType;

/**
 * Patient controller.
 *
 */
class PatientController extends Controller
{

    /**
     * Lists all Patient entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HospiceSiteBundle:Patient')->findAll();

        $entity = new Patient();
        $form = $this->createCreateForm($entity);


        return $this->render('HospiceSiteBundle:Patient:index.html.twig', array(
            'entities' => $entities,
            'form'   => $form->createView(),
        ));
    }
    /**
     * Lists all Patients entities.
     *
     */
    public function getJSONEntitiesAction($queryString)
    {
    	$em = $this->getDoctrine()->getManager();
    
    	if ($queryString == null || $queryString == "") {
    		$entities = $em->getRepository('HospiceSiteBundle:Patient')->findAll();
    	} else {
    		$query = $em->getRepository('HospiceSiteBundle:Patient')->createQueryBuilder('p')
    		->where('p.name LIKE :query')
    		->orWhere('p.lastname LIKE :query')
    		->orWhere('p.pesel LIKE :query')
    		->orWhere('p.address LIKE :query')
    		->setParameter('query', '%' . $queryString . '%')
    		->getQuery();
    		$entities = $query->getResult();
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
     * Creates a new Patient entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Patient();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('patient_show', array('id' => $entity->getId())));
        }

        return $this->render('HospiceSiteBundle:Patient:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Patient entity.
    *
    * @param Patient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Patient $entity)
    {
        $patientType = new PatientType();
        $form = $this->createForm($patientType, $entity, array(
            'attr' => ['id' => $patientType->getName() . "_id"],
            'action' => $this->generateUrl('patient_create'),
            'method' => 'POST',
        ));

//        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Patient entity.
     *
     */
    public function newAction()
    {
        $entity = new Patient();
        $form   = $this->createCreateForm($entity);

        return $this->render('HospiceSiteBundle:Patient:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Patient entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Patient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HospiceSiteBundle:Patient:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Patient entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Patient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patient entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('HospiceSiteBundle:Patient:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Patient entity.
    *
    * @param Patient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Patient $entity)
    {
        $form = $this->createForm(new PatientType(), $entity, array(
            'action' => $this->generateUrl('patient_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Patient entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('HospiceSiteBundle:Patient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Patient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('patient_edit', array('id' => $id)));
        }

        return $this->render('HospiceSiteBundle:Patient:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Patient entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('HospiceSiteBundle:Patient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Patient entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('patient'));
    }

    /**
     * Creates a form to delete a Patient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('patient_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

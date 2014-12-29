<?php

namespace Hospice\SiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Users controller.
 *
 */
class UsersController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('HospiceSiteBundle:Patient')->findAll();

        return $this->render('HospiceSiteBundle:Patient:index.html.twig', array(
            'entities' => $entities
        ));
    }
	
}

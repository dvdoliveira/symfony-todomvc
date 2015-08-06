<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AppBundle:Todo')->findAll();
        $entity = new Todo();
        $form   = $this->createForm(new TodoType(), $entity);
        return $this->render('default/index.html.twig', array(
          'entities' => $entities,
          'form'   => $form->createView(),
          ));
        // return $this->render('default/index.html.twig', array(
        //     'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        // ));
    }
}

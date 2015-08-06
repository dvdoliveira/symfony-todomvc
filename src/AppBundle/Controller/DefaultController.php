<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Todo;
use AppBundle\Form\TodoType;

class DefaultController extends Controller
{
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
    }

    public function createAction(Request $request)
    {
        $entity  = new Todo();
        $form = $this->createForm(new TodoType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('todo'));
        }
        return $this->render('AppBundle:Todo:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
      ));
    }
}

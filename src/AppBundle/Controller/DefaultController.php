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

    public function updateAction(Request $request, $id)
    {
        if ($request->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getManager();

            $entity = $em->getRepository('AppBundle:Todo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Todo was not found.');
            } else {
                $finished = $entity->getCompleted();
                if ( $finished == 0) {
                    $entity->setCompleted(1);
                } else {
                    $entity->setCompleted(0);
                }
            $em->persist($entity);
            $em->flush();

            $response = new Response(json_encode(array('completed' => $entity->getCompleted())));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
            }
        }
    }

    public function deleteAction($id, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Todo')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Todo was not found.');
        }
        $csrf  = $this->container->get('form.csrf_provider');

        if ($csrf->isCsrfTokenValid($entity->getCsrfIntention('delete'), $token)) {
            $em->remove($entity);
            $em->flush();
        } else {
            throw $this->createNotFoundException('Invalid token.');
        }

        return $this->redirect($this->generateUrl('todo'));
    }

    public function clearcompletedAction() 
    {
        $em = $this->getDoctrine()->getManager();

        $unfinished = $em->getRepository('AppBundle:Todo')->findBy(array('completed' => 1));
        if ($unfinished) {
          foreach ($unfinished as $c) {
            $em->remove($c);
          }
          $em->flush();
        }
        return $this->redirect($this->generateUrl('todo'));
    }

    public function toggleAction() 
    {
        $em = $this->getDoctrine()->getManager();
        $unfinished = $em->getRepository('AppBundle:Todo')->findBy(array('completed' => 0));
        if ($unfinished) {
            foreach ($unfinished as $c) {
                $c->setCompleted(1);
                $em->persist($c);
            }
            $em->flush();
        }
        return $this->redirect($this->generateUrl('todo'));
    }
}

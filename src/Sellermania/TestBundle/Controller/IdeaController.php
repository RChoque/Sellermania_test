<?php

namespace Sellermania\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sellermania\TestBundle\Entity\Idea;
use Sellermania\TestBundle\Form\IdeaType;

/**
 * Idea controller.
 *
 */
class IdeaController extends Controller
{
    /**
     * Lists all Idea entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ideas = $em->getRepository('SellermaniaTestBundle:Idea')->findAll();

        return $this->render('SellermaniaTestBundle:Idea:index.html.twig', array(
            'ideas' => $ideas,
        ));
    }

    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository('SellermaniaTestBundle:Idea')->findAll();

        $data = $this->container->get('serializer')->serialize($orders, 'json');
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $response->setContent($data);
        return $response;
    }

    /**
     * Creates a new Idea entity.
     *
     */
    public function newAction(Request $request)
    {
        $idea = new Idea();
        $form = $this->createForm('Sellermania\TestBundle\Form\IdeaType', $idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($idea);
            $em->flush();

            return $this->redirectToRoute('show_idea', array('id' => $idea->getId()));
        }

        return $this->render('SellermaniaTestBundle:Idea:new.html.twig', array(
            'idea' => $idea,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Idea entity.
     *
     */
    public function showAction(Idea $idea)
    {
        $deleteForm = $this->createDeleteForm($idea);

        return $this->render('SellermaniaTestBundle:Idea:show.html.twig', array(
            'idea' => $idea,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Idea entity.
     *
     */
    public function editAction(Request $request, Idea $idea)
    {
        $deleteForm = $this->createDeleteForm($idea);
        $editForm = $this->createForm('Sellermania\TestBundle\Form\IdeaType', $idea);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($idea);
            $em->flush();

            return $this->redirectToRoute('edit_idea', array('id' => $idea->getId()));
        }

        return $this->render('SellermaniaTestBundle:Idea:edit.html.twig', array(
            'idea' => $idea,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Idea entity.
     *
     */
    public function deleteAction(Request $request, Idea $idea)
    {
        $form = $this->createDeleteForm($idea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($idea);
            $em->flush();
        }

        return $this->redirectToRoute('idea_list');
    }

    /**
     * Creates a form to delete a Idea entity.
     *
     * @param Idea $idea The Idea entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Idea $idea)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delete_idea', array('id' => $idea->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

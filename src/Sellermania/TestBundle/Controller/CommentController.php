<?php

namespace Sellermania\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sellermania\TestBundle\Entity\Comment;
use Sellermania\TestBundle\Form\CommentType;
use Sellermania\TestBundle\Entity\Idea;

/**
 * Comment controller.
 *
 */
class CommentController extends Controller
{
    /**
     * Creates a new Comment entity.
     *
     */
    public function newAction(Request $request, Idea $idea)
    {
        $comment = new Comment();
        $form = $this->createForm('Sellermania\TestBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setIdea($idea);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('show_idea', array('id' => $idea->getId()));
        }

        return $this->render('SellermaniaTestBundle:Comment:new.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView(),
            'idea' => $idea
        ));
    }

    /**
     * Displays a form to edit an existing Comment entity.
     *
     */
    public function editAction(Request $request, Comment $comment)
    {
        $deleteForm = $this->createDeleteForm($comment);
        $editForm = $this->createForm('Sellermania\TestBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $comment->getId()));
        }

        return $this->render('comment/edit.html.twig', array(
            'comment' => $comment,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


}

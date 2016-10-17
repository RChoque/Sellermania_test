<?php

namespace Sellermania\TestBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sellermania\TestBundle\Entity\Vote;
use Sellermania\TestBundle\Entity\Idea;

/**
 * Vote controller.
 *
 */
class VoteController extends Controller
{
    /**
     * Creates a new Vote entity.
     *
     */
    public function newAction(Request $request, Idea $idea, $value)
    {
        if(is_numeric(intval($value)))
        {
            $vote = new Vote();
            $vote->setValue(intval($value));
            $vote->setIdea($idea);
            $em = $this->getDoctrine()->getManager();
            $em->persist($vote);
            $em->flush();
            return new JsonResponse(true);
        }else{
            return new JsonResponse(false);
        }
    }

}

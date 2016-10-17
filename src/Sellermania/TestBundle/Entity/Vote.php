<?php

namespace Sellermania\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="Sellermania\TestBundle\Entity\Repository\VoteRepository")
 */
class Vote
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="integer", nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Idea", inversedBy="comments", cascade={"persist"})
     * @ORM\JoinColumn(name="idea_id", referencedColumnName="id" , nullable=false)
     */
    private $idea;

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Order
     */
    public function setValue($value)
    {
        if($value > 0){
            $value = 1;
        }else{
            if($value < 0){
                $value = -1;
            }
        }
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set idea
     *
     * @param \Sellermania\TestBundle\Entity\Idea $idea
     *
     * @return Comment
     */
    public function setIdea(\Sellermania\TestBundle\Entity\Idea $idea = null)
    {
        $this->idea = $idea;

        return $this;
    }

    /**
     * Get idea
     *
     * @return \Sellermania\TestBundle\Entity\Idea
     */
    public function getIdea()
    {
        return $this->idea;
    }

}
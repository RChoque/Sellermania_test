<?php

namespace Sellermania\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="Sellermania\TestBundle\Entity\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="content", type="string", length=25, nullable=true)
     */
    private $content;

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
     * Set content
     *
     * @param string $content
     * @return Order
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
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
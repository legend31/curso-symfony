<?php

namespace Curso\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Curso\MainBundle\Entity\CommentsRepository")
 */
class Comments
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
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var integer
     *
     * @ORM\Column(name="reply_to", type="integer")
     */
    private $replyTo;
	
    /**
     * @ORM\ManyToOne(targetEntity="Articles", inversedBy="comments")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     * @return integer
     */
    private $article;
    
    public function setArticle(Curso\MainBundle\Entity\Articles $article)
    {
    	$this->article = $article;
    }
    
    public function getArticle()
    {
    	return $this->article;
    }
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Comments
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comments
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
     * Set replyTo
     *
     * @param integer $replyTo
     * @return Comments
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * Get replyTo
     *
     * @return integer 
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }
}

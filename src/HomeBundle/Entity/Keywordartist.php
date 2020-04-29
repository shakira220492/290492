<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keywordartist
 *
 * @ORM\Table(name="keywordArtist", indexes={@ORM\Index(name="keyword_id", columns={"keyword_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Keywordartist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="keywordArtist_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $keywordartistId;

    /**
     * @var \Keyword
     *
     * @ORM\ManyToOne(targetEntity="Keyword")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="keyword_id", referencedColumnName="keyword_id")
     * })
     */
    private $keyword;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;



    /**
     * Get keywordartistId
     *
     * @return integer
     */
    public function getKeywordartistId()
    {
        return $this->keywordartistId;
    }

    /**
     * Set keyword
     *
     * @param \HomeBundle\Entity\Keyword $keyword
     *
     * @return Keywordartist
     */
    public function setKeyword(\HomeBundle\Entity\Keyword $keyword = null)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return \HomeBundle\Entity\Keyword
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Keywordartist
     */
    public function setUser(\HomeBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HomeBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

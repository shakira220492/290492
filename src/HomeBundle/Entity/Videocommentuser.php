<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videocommentuser
 *
 * @ORM\Table(name="videoCommentUser", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="videoComment_id", columns={"videoComment_id"})})
 * @ORM\Entity
 */
class Videocommentuser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="videoCommentUser_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videocommentuserId;

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
     * @var \Videocomment
     *
     * @ORM\ManyToOne(targetEntity="Videocomment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="videoComment_id", referencedColumnName="videoComment_id")
     * })
     */
    private $videocomment;



    /**
     * Get videocommentuserId
     *
     * @return integer
     */
    public function getVideocommentuserId()
    {
        return $this->videocommentuserId;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Videocommentuser
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

    /**
     * Set videocomment
     *
     * @param \HomeBundle\Entity\Videocomment $videocomment
     *
     * @return Videocommentuser
     */
    public function setVideocomment(\HomeBundle\Entity\Videocomment $videocomment = null)
    {
        $this->videocomment = $videocomment;

        return $this;
    }

    /**
     * Get videocomment
     *
     * @return \HomeBundle\Entity\Videocomment
     */
    public function getVideocomment()
    {
        return $this->videocomment;
    }
}

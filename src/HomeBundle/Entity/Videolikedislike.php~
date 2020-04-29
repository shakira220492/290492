<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videolikedislike
 *
 * @ORM\Table(name="videoLikeDislike", indexes={@ORM\Index(name="video_id", columns={"video_id"}), @ORM\Index(name="user_id", columns={"user_id"})})
 * @ORM\Entity
 */
class Videolikedislike
{
    /**
     * @var integer
     *
     * @ORM\Column(name="videoLikeDislike_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videolikedislikeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="videoLikeDislike_valoration", type="integer", nullable=false)
     */
    private $videolikedislikeValoration;

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
     * @var \Video
     *
     * @ORM\ManyToOne(targetEntity="Video")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="video_id", referencedColumnName="video_id")
     * })
     */
    private $video;



    /**
     * Get videolikedislikeId
     *
     * @return integer
     */
    public function getVideolikedislikeId()
    {
        return $this->videolikedislikeId;
    }

    /**
     * Set videolikedislikeValoration
     *
     * @param integer $videolikedislikeValoration
     *
     * @return Videolikedislike
     */
    public function setVideolikedislikeValoration($videolikedislikeValoration)
    {
        $this->videolikedislikeValoration = $videolikedislikeValoration;

        return $this;
    }

    /**
     * Get videolikedislikeValoration
     *
     * @return integer
     */
    public function getVideolikedislikeValoration()
    {
        return $this->videolikedislikeValoration;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Videolikedislike
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
     * Set video
     *
     * @param \HomeBundle\Entity\Video $video
     *
     * @return Videolikedislike
     */
    public function setVideo(\HomeBundle\Entity\Video $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return \HomeBundle\Entity\Video
     */
    public function getVideo()
    {
        return $this->video;
    }
}

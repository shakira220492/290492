<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 *
 * @ORM\Table(name="video", indexes={@ORM\Index(name="id_user", columns={"user_id"})})
 * @ORM\Entity
 */
class Video
{
    /**
     * @var integer
     *
     * @ORM\Column(name="video_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videoId;

    /**
     * @var string
     *
     * @ORM\Column(name="video_name", type="string", length=100, nullable=false)
     */
    private $videoName;

    /**
     * @var string
     *
     * @ORM\Column(name="video_description", type="string", length=500, nullable=false)
     */
    private $videoDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="video_image", type="string", length=255, nullable=false)
     */
    private $videoImage;

    /**
     * @var string
     *
     * @ORM\Column(name="video_content", type="string", length=255, nullable=false)
     */
    private $videoContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="video_updateDate", type="date", nullable=false)
     */
    private $videoUpdatedate;

    /**
     * @var integer
     *
     * @ORM\Column(name="video_amount_views", type="integer", nullable=false)
     */
    private $videoAmountViews;

    /**
     * @var integer
     *
     * @ORM\Column(name="video_amount_comments", type="integer", nullable=false)
     */
    private $videoAmountComments;

    /**
     * @var integer
     *
     * @ORM\Column(name="video_score", type="integer", nullable=false)
     */
    private $videoScore;

    /**
     * @var integer
     *
     * @ORM\Column(name="video_peopleScore", type="integer", nullable=false)
     */
    private $videoPeoplescore;

    /**
     * @var integer
     *
     * @ORM\Column(name="video_coin_score", type="integer", nullable=false)
     */
    private $videoCoinScore;

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
     * Get videoId
     *
     * @return integer
     */
    public function getVideoId()
    {
        return $this->videoId;
    }

    /**
     * Set videoName
     *
     * @param string $videoName
     *
     * @return Video
     */
    public function setVideoName($videoName)
    {
        $this->videoName = $videoName;

        return $this;
    }

    /**
     * Get videoName
     *
     * @return string
     */
    public function getVideoName()
    {
        return $this->videoName;
    }

    /**
     * Set videoDescription
     *
     * @param string $videoDescription
     *
     * @return Video
     */
    public function setVideoDescription($videoDescription)
    {
        $this->videoDescription = $videoDescription;

        return $this;
    }

    /**
     * Get videoDescription
     *
     * @return string
     */
    public function getVideoDescription()
    {
        return $this->videoDescription;
    }

    /**
     * Set videoImage
     *
     * @param string $videoImage
     *
     * @return Video
     */
    public function setVideoImage($videoImage)
    {
        $this->videoImage = $videoImage;

        return $this;
    }

    /**
     * Get videoImage
     *
     * @return string
     */
    public function getVideoImage()
    {
        return $this->videoImage;
    }

    /**
     * Set videoContent
     *
     * @param string $videoContent
     *
     * @return Video
     */
    public function setVideoContent($videoContent)
    {
        $this->videoContent = $videoContent;

        return $this;
    }

    /**
     * Get videoContent
     *
     * @return string
     */
    public function getVideoContent()
    {
        return $this->videoContent;
    }

    /**
     * Set videoUpdatedate
     *
     * @param \DateTime $videoUpdatedate
     *
     * @return Video
     */
    public function setVideoUpdatedate($videoUpdatedate)
    {
        $this->videoUpdatedate = $videoUpdatedate;

        return $this;
    }

    /**
     * Get videoUpdatedate
     *
     * @return \DateTime
     */
    public function getVideoUpdatedate()
    {
        return $this->videoUpdatedate;
    }

    /**
     * Set videoAmountViews
     *
     * @param integer $videoAmountViews
     *
     * @return Video
     */
    public function setVideoAmountViews($videoAmountViews)
    {
        $this->videoAmountViews = $videoAmountViews;

        return $this;
    }

    /**
     * Get videoAmountViews
     *
     * @return integer
     */
    public function getVideoAmountViews()
    {
        return $this->videoAmountViews;
    }

    /**
     * Set videoAmountComments
     *
     * @param integer $videoAmountComments
     *
     * @return Video
     */
    public function setVideoAmountComments($videoAmountComments)
    {
        $this->videoAmountComments = $videoAmountComments;

        return $this;
    }

    /**
     * Get videoAmountComments
     *
     * @return integer
     */
    public function getVideoAmountComments()
    {
        return $this->videoAmountComments;
    }

    /**
     * Set videoScore
     *
     * @param integer $videoScore
     *
     * @return Video
     */
    public function setVideoScore($videoScore)
    {
        $this->videoScore = $videoScore;

        return $this;
    }

    /**
     * Get videoScore
     *
     * @return integer
     */
    public function getVideoScore()
    {
        return $this->videoScore;
    }

    /**
     * Set videoPeoplescore
     *
     * @param integer $videoPeoplescore
     *
     * @return Video
     */
    public function setVideoPeoplescore($videoPeoplescore)
    {
        $this->videoPeoplescore = $videoPeoplescore;

        return $this;
    }

    /**
     * Get videoPeoplescore
     *
     * @return integer
     */
    public function getVideoPeoplescore()
    {
        return $this->videoPeoplescore;
    }

    /**
     * Set videoCoinScore
     *
     * @param integer $videoCoinScore
     *
     * @return Video
     */
    public function setVideoCoinScore($videoCoinScore)
    {
        $this->videoCoinScore = $videoCoinScore;

        return $this;
    }

    /**
     * Get videoCoinScore
     *
     * @return integer
     */
    public function getVideoCoinScore()
    {
        return $this->videoCoinScore;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Video
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

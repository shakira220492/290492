<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videoscore
 *
 * @ORM\Table(name="videoScore", indexes={@ORM\Index(name="videoUser_id", columns={"videoUser_id"})})
 * @ORM\Entity
 */
class Videoscore
{
    /**
     * @var integer
     *
     * @ORM\Column(name="videoScore_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videoscoreId;

    /**
     * @var integer
     *
     * @ORM\Column(name="videoScore_punctuation", type="integer", nullable=false)
     */
    private $videoscorePunctuation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="videoScore_date", type="datetime", nullable=false)
     */
    private $videoscoreDate;

    /**
     * @var \Videouser
     *
     * @ORM\ManyToOne(targetEntity="Videouser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="videoUser_id", referencedColumnName="videoUser_id")
     * })
     */
    private $videouser;



    /**
     * Get videoscoreId
     *
     * @return integer
     */
    public function getVideoscoreId()
    {
        return $this->videoscoreId;
    }

    /**
     * Set videoscorePunctuation
     *
     * @param integer $videoscorePunctuation
     *
     * @return Videoscore
     */
    public function setVideoscorePunctuation($videoscorePunctuation)
    {
        $this->videoscorePunctuation = $videoscorePunctuation;

        return $this;
    }

    /**
     * Get videoscorePunctuation
     *
     * @return integer
     */
    public function getVideoscorePunctuation()
    {
        return $this->videoscorePunctuation;
    }

    /**
     * Set videoscoreDate
     *
     * @param \DateTime $videoscoreDate
     *
     * @return Videoscore
     */
    public function setVideoscoreDate($videoscoreDate)
    {
        $this->videoscoreDate = $videoscoreDate;

        return $this;
    }

    /**
     * Get videoscoreDate
     *
     * @return \DateTime
     */
    public function getVideoscoreDate()
    {
        return $this->videoscoreDate;
    }

    /**
     * Set videouser
     *
     * @param \HomeBundle\Entity\Videouser $videouser
     *
     * @return Videoscore
     */
    public function setVideouser(\HomeBundle\Entity\Videouser $videouser = null)
    {
        $this->videouser = $videouser;

        return $this;
    }

    /**
     * Get videouser
     *
     * @return \HomeBundle\Entity\Videouser
     */
    public function getVideouser()
    {
        return $this->videouser;
    }
}

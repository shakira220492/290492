<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videoview
 *
 * @ORM\Table(name="videoView", indexes={@ORM\Index(name="videoUser_id", columns={"videoUser_id"})})
 * @ORM\Entity
 */
class Videoview
{
    /**
     * @var integer
     *
     * @ORM\Column(name="videoView_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videoviewId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="videoView_date", type="date", nullable=false)
     */
    private $videoviewDate;

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
     * Get videoviewId
     *
     * @return integer
     */
    public function getVideoviewId()
    {
        return $this->videoviewId;
    }

    /**
     * Set videoviewDate
     *
     * @param \DateTime $videoviewDate
     *
     * @return Videoview
     */
    public function setVideoviewDate($videoviewDate)
    {
        $this->videoviewDate = $videoviewDate;

        return $this;
    }

    /**
     * Get videoviewDate
     *
     * @return \DateTime
     */
    public function getVideoviewDate()
    {
        return $this->videoviewDate;
    }

    /**
     * Set videouser
     *
     * @param \HomeBundle\Entity\Videouser $videouser
     *
     * @return Videoview
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

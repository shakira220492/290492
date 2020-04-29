<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videodonation
 *
 * @ORM\Table(name="videoDonation", indexes={@ORM\Index(name="videoUser_id", columns={"videoUser_id"})})
 * @ORM\Entity
 */
class Videodonation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="videoDonation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videodonationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="videoDonation_amount", type="integer", nullable=false)
     */
    private $videodonationAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="videoDonation_date", type="date", nullable=false)
     */
    private $videodonationDate;

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
     * Get videodonationId
     *
     * @return integer
     */
    public function getVideodonationId()
    {
        return $this->videodonationId;
    }

    /**
     * Set videodonationAmount
     *
     * @param integer $videodonationAmount
     *
     * @return Videodonation
     */
    public function setVideodonationAmount($videodonationAmount)
    {
        $this->videodonationAmount = $videodonationAmount;

        return $this;
    }

    /**
     * Get videodonationAmount
     *
     * @return integer
     */
    public function getVideodonationAmount()
    {
        return $this->videodonationAmount;
    }

    /**
     * Set videodonationDate
     *
     * @param \DateTime $videodonationDate
     *
     * @return Videodonation
     */
    public function setVideodonationDate($videodonationDate)
    {
        $this->videodonationDate = $videodonationDate;

        return $this;
    }

    /**
     * Get videodonationDate
     *
     * @return \DateTime
     */
    public function getVideodonationDate()
    {
        return $this->videodonationDate;
    }

    /**
     * Set videouser
     *
     * @param \HomeBundle\Entity\Videouser $videouser
     *
     * @return Videodonation
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

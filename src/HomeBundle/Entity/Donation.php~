<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Donation
 *
 * @ORM\Table(name="donation", indexes={@ORM\Index(name="videoUser_id", columns={"videoUser_id"})})
 * @ORM\Entity
 */
class Donation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="donation_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $donationId;

    /**
     * @var integer
     *
     * @ORM\Column(name="donation_amount", type="integer", nullable=false)
     */
    private $donationAmount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="donation_date", type="date", nullable=false)
     */
    private $donationDate;

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
     * Get donationId
     *
     * @return integer
     */
    public function getDonationId()
    {
        return $this->donationId;
    }

    /**
     * Set donationAmount
     *
     * @param integer $donationAmount
     *
     * @return Donation
     */
    public function setDonationAmount($donationAmount)
    {
        $this->donationAmount = $donationAmount;

        return $this;
    }

    /**
     * Get donationAmount
     *
     * @return integer
     */
    public function getDonationAmount()
    {
        return $this->donationAmount;
    }

    /**
     * Set donationDate
     *
     * @param \DateTime $donationDate
     *
     * @return Donation
     */
    public function setDonationDate($donationDate)
    {
        $this->donationDate = $donationDate;

        return $this;
    }

    /**
     * Get donationDate
     *
     * @return \DateTime
     */
    public function getDonationDate()
    {
        return $this->donationDate;
    }

    /**
     * Set videouser
     *
     * @param \HomeBundle\Entity\Videouser $videouser
     *
     * @return Donation
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

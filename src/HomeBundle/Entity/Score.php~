<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Score
 *
 * @ORM\Table(name="score")
 * @ORM\Entity
 */
class Score
{
    /**
     * @var integer
     *
     * @ORM\Column(name="score_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $scoreId;

    /**
     * @var integer
     *
     * @ORM\Column(name="videoUser_id", type="integer", nullable=false)
     */
    private $videouserId;

    /**
     * @var integer
     *
     * @ORM\Column(name="score_punctuation", type="integer", nullable=false)
     */
    private $scorePunctuation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="score_date", type="date", nullable=false)
     */
    private $scoreDate;



    /**
     * Get scoreId
     *
     * @return integer
     */
    public function getScoreId()
    {
        return $this->scoreId;
    }

    /**
     * Set videouserId
     *
     * @param integer $videouserId
     *
     * @return Score
     */
    public function setVideouserId($videouserId)
    {
        $this->videouserId = $videouserId;

        return $this;
    }

    /**
     * Get videouserId
     *
     * @return integer
     */
    public function getVideouserId()
    {
        return $this->videouserId;
    }

    /**
     * Set scorePunctuation
     *
     * @param integer $scorePunctuation
     *
     * @return Score
     */
    public function setScorePunctuation($scorePunctuation)
    {
        $this->scorePunctuation = $scorePunctuation;

        return $this;
    }

    /**
     * Get scorePunctuation
     *
     * @return integer
     */
    public function getScorePunctuation()
    {
        return $this->scorePunctuation;
    }

    /**
     * Set scoreDate
     *
     * @param \DateTime $scoreDate
     *
     * @return Score
     */
    public function setScoreDate($scoreDate)
    {
        $this->scoreDate = $scoreDate;

        return $this;
    }

    /**
     * Get scoreDate
     *
     * @return \DateTime
     */
    public function getScoreDate()
    {
        return $this->scoreDate;
    }
}

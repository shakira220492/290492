<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videocommentscore
 *
 * @ORM\Table(name="videoCommentScore", indexes={@ORM\Index(name="videoCommentUser_id", columns={"videoCommentUser_id"})})
 * @ORM\Entity
 */
class Videocommentscore
{
    /**
     * @var integer
     *
     * @ORM\Column(name="videoCommentScore_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videocommentscoreId;

    /**
     * @var integer
     *
     * @ORM\Column(name="videoCommentScore_punctuation", type="integer", nullable=false)
     */
    private $videocommentscorePunctuation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="videoCommentScore_date", type="date", nullable=false)
     */
    private $videocommentscoreDate;

    /**
     * @var \Videocommentuser
     *
     * @ORM\ManyToOne(targetEntity="Videocommentuser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="videoCommentUser_id", referencedColumnName="videoCommentUser_id")
     * })
     */
    private $videocommentuser;



    /**
     * Get videocommentscoreId
     *
     * @return integer
     */
    public function getVideocommentscoreId()
    {
        return $this->videocommentscoreId;
    }

    /**
     * Set videocommentscorePunctuation
     *
     * @param integer $videocommentscorePunctuation
     *
     * @return Videocommentscore
     */
    public function setVideocommentscorePunctuation($videocommentscorePunctuation)
    {
        $this->videocommentscorePunctuation = $videocommentscorePunctuation;

        return $this;
    }

    /**
     * Get videocommentscorePunctuation
     *
     * @return integer
     */
    public function getVideocommentscorePunctuation()
    {
        return $this->videocommentscorePunctuation;
    }

    /**
     * Set videocommentscoreDate
     *
     * @param \DateTime $videocommentscoreDate
     *
     * @return Videocommentscore
     */
    public function setVideocommentscoreDate($videocommentscoreDate)
    {
        $this->videocommentscoreDate = $videocommentscoreDate;

        return $this;
    }

    /**
     * Get videocommentscoreDate
     *
     * @return \DateTime
     */
    public function getVideocommentscoreDate()
    {
        return $this->videocommentscoreDate;
    }

    /**
     * Set videocommentuser
     *
     * @param \HomeBundle\Entity\Videocommentuser $videocommentuser
     *
     * @return Videocommentscore
     */
    public function setVideocommentuser(\HomeBundle\Entity\Videocommentuser $videocommentuser = null)
    {
        $this->videocommentuser = $videocommentuser;

        return $this;
    }

    /**
     * Get videocommentuser
     *
     * @return \HomeBundle\Entity\Videocommentuser
     */
    public function getVideocommentuser()
    {
        return $this->videocommentuser;
    }
}

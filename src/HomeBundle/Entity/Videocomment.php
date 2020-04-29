<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videocomment
 *
 * @ORM\Table(name="videoComment", indexes={@ORM\Index(name="videoUser_id", columns={"videoUser_id"})})
 * @ORM\Entity
 */
class Videocomment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="videoComment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $videocommentId;

    /**
     * @var string
     *
     * @ORM\Column(name="videoComment_content", type="string", length=170, nullable=false)
     */
    private $videocommentContent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="videoComment_date", type="datetime", nullable=false)
     */
    private $videocommentDate;

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
     * Get videocommentId
     *
     * @return integer
     */
    public function getVideocommentId()
    {
        return $this->videocommentId;
    }

    /**
     * Set videocommentContent
     *
     * @param string $videocommentContent
     *
     * @return Videocomment
     */
    public function setVideocommentContent($videocommentContent)
    {
        $this->videocommentContent = $videocommentContent;

        return $this;
    }

    /**
     * Get videocommentContent
     *
     * @return string
     */
    public function getVideocommentContent()
    {
        return $this->videocommentContent;
    }

    /**
     * Set videocommentDate
     *
     * @param \DateTime $videocommentDate
     *
     * @return Videocomment
     */
    public function setVideocommentDate($videocommentDate)
    {
        $this->videocommentDate = $videocommentDate;

        return $this;
    }

    /**
     * Get videocommentDate
     *
     * @return \DateTime
     */
    public function getVideocommentDate()
    {
        return $this->videocommentDate;
    }

    /**
     * Set videouser
     *
     * @param \HomeBundle\Entity\Videouser $videouser
     *
     * @return Videocomment
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

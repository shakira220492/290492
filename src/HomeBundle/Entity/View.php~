<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * View
 *
 * @ORM\Table(name="view", indexes={@ORM\Index(name="videoUser_id", columns={"videoUser_id"})})
 * @ORM\Entity
 */
class View
{
    /**
     * @var integer
     *
     * @ORM\Column(name="view_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $viewId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="view_date", type="date", nullable=false)
     */
    private $viewDate;

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
     * Get viewId
     *
     * @return integer
     */
    public function getViewId()
    {
        return $this->viewId;
    }

    /**
     * Set viewDate
     *
     * @param \DateTime $viewDate
     *
     * @return View
     */
    public function setViewDate($viewDate)
    {
        $this->viewDate = $viewDate;

        return $this;
    }

    /**
     * Get viewDate
     *
     * @return \DateTime
     */
    public function getViewDate()
    {
        return $this->viewDate;
    }

    /**
     * Set videouser
     *
     * @param \HomeBundle\Entity\Videouser $videouser
     *
     * @return View
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

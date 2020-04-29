<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producttype
 *
 * @ORM\Table(name="productType")
 * @ORM\Entity
 */
class Producttype
{
    /**
     * @var integer
     *
     * @ORM\Column(name="productType_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $producttypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="productType_name", type="string", length=255, nullable=false)
     */
    private $producttypeName;

    /**
     * @var integer
     *
     * @ORM\Column(name="productType_score", type="integer", nullable=false)
     */
    private $producttypeScore;



    /**
     * Get producttypeId
     *
     * @return integer
     */
    public function getProducttypeId()
    {
        return $this->producttypeId;
    }

    /**
     * Set producttypeName
     *
     * @param string $producttypeName
     *
     * @return Producttype
     */
    public function setProducttypeName($producttypeName)
    {
        $this->producttypeName = $producttypeName;

        return $this;
    }

    /**
     * Get producttypeName
     *
     * @return string
     */
    public function getProducttypeName()
    {
        return $this->producttypeName;
    }

    /**
     * Set producttypeScore
     *
     * @param integer $producttypeScore
     *
     * @return Producttype
     */
    public function setProducttypeScore($producttypeScore)
    {
        $this->producttypeScore = $producttypeScore;

        return $this;
    }

    /**
     * Get producttypeScore
     *
     * @return integer
     */
    public function getProducttypeScore()
    {
        return $this->producttypeScore;
    }
}

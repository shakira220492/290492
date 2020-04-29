<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keywordproducttype
 *
 * @ORM\Table(name="keywordProductType", indexes={@ORM\Index(name="keyword_id", columns={"keyword_id"}), @ORM\Index(name="productType_id", columns={"productType_id"})})
 * @ORM\Entity
 */
class Keywordproducttype
{
    /**
     * @var integer
     *
     * @ORM\Column(name="keywordProductType_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $keywordproducttypeId;

    /**
     * @var \Keyword
     *
     * @ORM\ManyToOne(targetEntity="Keyword")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="keyword_id", referencedColumnName="keyword_id")
     * })
     */
    private $keyword;

    /**
     * @var \Producttype
     *
     * @ORM\ManyToOne(targetEntity="Producttype")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="productType_id", referencedColumnName="productType_id")
     * })
     */
    private $producttype;



    /**
     * Get keywordproducttypeId
     *
     * @return integer
     */
    public function getKeywordproducttypeId()
    {
        return $this->keywordproducttypeId;
    }

    /**
     * Set keyword
     *
     * @param \HomeBundle\Entity\Keyword $keyword
     *
     * @return Keywordproducttype
     */
    public function setKeyword(\HomeBundle\Entity\Keyword $keyword = null)
    {
        $this->keyword = $keyword;

        return $this;
    }

    /**
     * Get keyword
     *
     * @return \HomeBundle\Entity\Keyword
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * Set producttype
     *
     * @param \HomeBundle\Entity\Producttype $producttype
     *
     * @return Keywordproducttype
     */
    public function setProducttype(\HomeBundle\Entity\Producttype $producttype = null)
    {
        $this->producttype = $producttype;

        return $this;
    }

    /**
     * Get producttype
     *
     * @return \HomeBundle\Entity\Producttype
     */
    public function getProducttype()
    {
        return $this->producttype;
    }
}

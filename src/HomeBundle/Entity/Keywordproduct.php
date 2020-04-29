<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Keywordproduct
 *
 * @ORM\Table(name="keywordProduct", indexes={@ORM\Index(name="keyword_id", columns={"keyword_id"}), @ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class Keywordproduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="keywordProduct_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $keywordproductId;

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
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;



    /**
     * Get keywordproductId
     *
     * @return integer
     */
    public function getKeywordproductId()
    {
        return $this->keywordproductId;
    }

    /**
     * Set keyword
     *
     * @param \HomeBundle\Entity\Keyword $keyword
     *
     * @return Keywordproduct
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
     * Set product
     *
     * @param \HomeBundle\Entity\Product $product
     *
     * @return Keywordproduct
     */
    public function setProduct(\HomeBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \HomeBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}

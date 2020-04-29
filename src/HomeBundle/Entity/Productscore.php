<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Productscore
 *
 * @ORM\Table(name="productScore", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class Productscore
{
    /**
     * @var integer
     *
     * @ORM\Column(name="productScore_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productscoreId;

    /**
     * @var integer
     *
     * @ORM\Column(name="productScore_punctuation", type="integer", nullable=false)
     */
    private $productscorePunctuation;

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
     * Get productscoreId
     *
     * @return integer
     */
    public function getProductscoreId()
    {
        return $this->productscoreId;
    }

    /**
     * Set productscorePunctuation
     *
     * @param integer $productscorePunctuation
     *
     * @return Productscore
     */
    public function setProductscorePunctuation($productscorePunctuation)
    {
        $this->productscorePunctuation = $productscorePunctuation;

        return $this;
    }

    /**
     * Get productscorePunctuation
     *
     * @return integer
     */
    public function getProductscorePunctuation()
    {
        return $this->productscorePunctuation;
    }

    /**
     * Set product
     *
     * @param \HomeBundle\Entity\Product $product
     *
     * @return Productscore
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

<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Productimage
 *
 * @ORM\Table(name="productImage", indexes={@ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class Productimage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="productImage_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productimageId;

    /**
     * @var string
     *
     * @ORM\Column(name="productImage_image", type="string", length=255, nullable=false)
     */
    private $productimageImage;

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
     * Get productimageId
     *
     * @return integer
     */
    public function getProductimageId()
    {
        return $this->productimageId;
    }

    /**
     * Set productimageImage
     *
     * @param string $productimageImage
     *
     * @return Productimage
     */
    public function setProductimageImage($productimageImage)
    {
        $this->productimageImage = $productimageImage;

        return $this;
    }

    /**
     * Get productimageImage
     *
     * @return string
     */
    public function getProductimageImage()
    {
        return $this->productimageImage;
    }

    /**
     * Set product
     *
     * @param \HomeBundle\Entity\Product $product
     *
     * @return Productimage
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

<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sellingproduct
 *
 * @ORM\Table(name="sellingProduct", indexes={@ORM\Index(name="stock_id", columns={"stock_id"}), @ORM\Index(name="customer_id", columns={"customer_id"}), @ORM\Index(name="product_id", columns={"product_id"})})
 * @ORM\Entity
 */
class Sellingproduct
{
    /**
     * @var integer
     *
     * @ORM\Column(name="sellingProduct_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sellingproductId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sellingProduct_date", type="datetime", nullable=false)
     */
    private $sellingproductDate;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="customer_id", referencedColumnName="user_id")
     * })
     */
    private $customer;

    /**
     * @var \Stock
     *
     * @ORM\ManyToOne(targetEntity="Stock")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="stock_id", referencedColumnName="stock_id")
     * })
     */
    private $stock;

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
     * Get sellingproductId
     *
     * @return integer
     */
    public function getSellingproductId()
    {
        return $this->sellingproductId;
    }

    /**
     * Set sellingproductDate
     *
     * @param \DateTime $sellingproductDate
     *
     * @return Sellingproduct
     */
    public function setSellingproductDate($sellingproductDate)
    {
        $this->sellingproductDate = $sellingproductDate;

        return $this;
    }

    /**
     * Get sellingproductDate
     *
     * @return \DateTime
     */
    public function getSellingproductDate()
    {
        return $this->sellingproductDate;
    }

    /**
     * Set customer
     *
     * @param \HomeBundle\Entity\User $customer
     *
     * @return Sellingproduct
     */
    public function setCustomer(\HomeBundle\Entity\User $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \HomeBundle\Entity\User
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set stock
     *
     * @param \HomeBundle\Entity\Stock $stock
     *
     * @return Sellingproduct
     */
    public function setStock(\HomeBundle\Entity\Stock $stock = null)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \HomeBundle\Entity\Stock
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set product
     *
     * @param \HomeBundle\Entity\Product $product
     *
     * @return Sellingproduct
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

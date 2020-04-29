<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="stock", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="branch_id", columns={"branch_id"})})
 * @ORM\Entity
 */
class Stock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="stock_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $stockId;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock_amount", type="integer", nullable=false)
     */
    private $stockAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="stock_price", type="integer", nullable=false)
     */
    private $stockPrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stock_lastTransactionDate", type="datetime", nullable=false)
     */
    private $stockLasttransactiondate;

    /**
     * @var \Branch
     *
     * @ORM\ManyToOne(targetEntity="Branch")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="branch_id", referencedColumnName="branch_id")
     * })
     */
    private $branch;

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
     * Get stockId
     *
     * @return integer
     */
    public function getStockId()
    {
        return $this->stockId;
    }

    /**
     * Set stockAmount
     *
     * @param integer $stockAmount
     *
     * @return Stock
     */
    public function setStockAmount($stockAmount)
    {
        $this->stockAmount = $stockAmount;

        return $this;
    }

    /**
     * Get stockAmount
     *
     * @return integer
     */
    public function getStockAmount()
    {
        return $this->stockAmount;
    }

    /**
     * Set stockPrice
     *
     * @param integer $stockPrice
     *
     * @return Stock
     */
    public function setStockPrice($stockPrice)
    {
        $this->stockPrice = $stockPrice;

        return $this;
    }

    /**
     * Get stockPrice
     *
     * @return integer
     */
    public function getStockPrice()
    {
        return $this->stockPrice;
    }

    /**
     * Set stockLasttransactiondate
     *
     * @param \DateTime $stockLasttransactiondate
     *
     * @return Stock
     */
    public function setStockLasttransactiondate($stockLasttransactiondate)
    {
        $this->stockLasttransactiondate = $stockLasttransactiondate;

        return $this;
    }

    /**
     * Get stockLasttransactiondate
     *
     * @return \DateTime
     */
    public function getStockLasttransactiondate()
    {
        return $this->stockLasttransactiondate;
    }

    /**
     * Set branch
     *
     * @param \HomeBundle\Entity\Branch $branch
     *
     * @return Stock
     */
    public function setBranch(\HomeBundle\Entity\Branch $branch = null)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return \HomeBundle\Entity\Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * Set product
     *
     * @param \HomeBundle\Entity\Product $product
     *
     * @return Stock
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

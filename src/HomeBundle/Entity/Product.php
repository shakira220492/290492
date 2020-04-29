<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="artist_id", columns={"artist_id"}), @ORM\Index(name="productType_id", columns={"productType_id"}), @ORM\Index(name="song_id", columns={"song_id"})})
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $productId;

    /**
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255, nullable=false)
     */
    private $productName;

    /**
     * @var string
     *
     * @ORM\Column(name="product_price", type="decimal", precision=20, scale=2, nullable=false)
     */
    private $productPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="product_description", type="text", length=65535, nullable=false)
     */
    private $productDescription;

    /**
     * @var string
     *
     * @ORM\Column(name="product_image", type="string", length=255, nullable=false)
     */
    private $productImage;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * })
     */
    private $user;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="artist_id", referencedColumnName="user_id")
     * })
     */
    private $artist;

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
     * @var \Video
     *
     * @ORM\ManyToOne(targetEntity="Video")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="song_id", referencedColumnName="video_id")
     * })
     */
    private $song;



    /**
     * Get productId
     *
     * @return integer
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return Product
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * Set productPrice
     *
     * @param string $productPrice
     *
     * @return Product
     */
    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    /**
     * Get productPrice
     *
     * @return string
     */
    public function getProductPrice()
    {
        return $this->productPrice;
    }

    /**
     * Set productDescription
     *
     * @param string $productDescription
     *
     * @return Product
     */
    public function setProductDescription($productDescription)
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    /**
     * Get productDescription
     *
     * @return string
     */
    public function getProductDescription()
    {
        return $this->productDescription;
    }

    /**
     * Set productImage
     *
     * @param string $productImage
     *
     * @return Product
     */
    public function setProductImage($productImage)
    {
        $this->productImage = $productImage;

        return $this;
    }

    /**
     * Get productImage
     *
     * @return string
     */
    public function getProductImage()
    {
        return $this->productImage;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Product
     */
    public function setUser(\HomeBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \HomeBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set artist
     *
     * @param \HomeBundle\Entity\User $artist
     *
     * @return Product
     */
    public function setArtist(\HomeBundle\Entity\User $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return \HomeBundle\Entity\User
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Set producttype
     *
     * @param \HomeBundle\Entity\Producttype $producttype
     *
     * @return Product
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

    /**
     * Set song
     *
     * @param \HomeBundle\Entity\Video $song
     *
     * @return Product
     */
    public function setSong(\HomeBundle\Entity\Video $song = null)
    {
        $this->song = $song;

        return $this;
    }

    /**
     * Get song
     *
     * @return \HomeBundle\Entity\Video
     */
    public function getSong()
    {
        return $this->song;
    }
}

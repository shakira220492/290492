<?php

namespace HomeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Branch
 *
 * @ORM\Table(name="branch", indexes={@ORM\Index(name="user_id", columns={"user_id"}), @ORM\Index(name="city_id", columns={"city_id"})})
 * @ORM\Entity
 */
class Branch
{
    /**
     * @var integer
     *
     * @ORM\Column(name="branch_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $branchId;

    /**
     * @var string
     *
     * @ORM\Column(name="branch_name", type="string", length=255, nullable=false)
     */
    private $branchName;

    /**
     * @var string
     *
     * @ORM\Column(name="branch_address", type="string", length=255, nullable=false)
     */
    private $branchAddress;

    /**
     * @var integer
     *
     * @ORM\Column(name="branch_telephone", type="integer", nullable=false)
     */
    private $branchTelephone;

    /**
     * @var integer
     *
     * @ORM\Column(name="branch_cellphone", type="integer", nullable=false)
     */
    private $branchCellphone;

    /**
     * @var string
     *
     * @ORM\Column(name="branch_aditional_information", type="text", length=65535, nullable=false)
     */
    private $branchAditionalInformation;

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
     * @var \City
     *
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="city_id", referencedColumnName="city_id")
     * })
     */
    private $city;



    /**
     * Get branchId
     *
     * @return integer
     */
    public function getBranchId()
    {
        return $this->branchId;
    }

    /**
     * Set branchName
     *
     * @param string $branchName
     *
     * @return Branch
     */
    public function setBranchName($branchName)
    {
        $this->branchName = $branchName;

        return $this;
    }

    /**
     * Get branchName
     *
     * @return string
     */
    public function getBranchName()
    {
        return $this->branchName;
    }

    /**
     * Set branchAddress
     *
     * @param string $branchAddress
     *
     * @return Branch
     */
    public function setBranchAddress($branchAddress)
    {
        $this->branchAddress = $branchAddress;

        return $this;
    }

    /**
     * Get branchAddress
     *
     * @return string
     */
    public function getBranchAddress()
    {
        return $this->branchAddress;
    }

    /**
     * Set branchTelephone
     *
     * @param integer $branchTelephone
     *
     * @return Branch
     */
    public function setBranchTelephone($branchTelephone)
    {
        $this->branchTelephone = $branchTelephone;

        return $this;
    }

    /**
     * Get branchTelephone
     *
     * @return integer
     */
    public function getBranchTelephone()
    {
        return $this->branchTelephone;
    }

    /**
     * Set branchCellphone
     *
     * @param integer $branchCellphone
     *
     * @return Branch
     */
    public function setBranchCellphone($branchCellphone)
    {
        $this->branchCellphone = $branchCellphone;

        return $this;
    }

    /**
     * Get branchCellphone
     *
     * @return integer
     */
    public function getBranchCellphone()
    {
        return $this->branchCellphone;
    }

    /**
     * Set branchAditionalInformation
     *
     * @param string $branchAditionalInformation
     *
     * @return Branch
     */
    public function setBranchAditionalInformation($branchAditionalInformation)
    {
        $this->branchAditionalInformation = $branchAditionalInformation;

        return $this;
    }

    /**
     * Get branchAditionalInformation
     *
     * @return string
     */
    public function getBranchAditionalInformation()
    {
        return $this->branchAditionalInformation;
    }

    /**
     * Set user
     *
     * @param \HomeBundle\Entity\User $user
     *
     * @return Branch
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
     * Set city
     *
     * @param \HomeBundle\Entity\City $city
     *
     * @return Branch
     */
    public function setCity(\HomeBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \HomeBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use League\Csv\Exception;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Product
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\Table(name="tblProductData", uniqueConstraints={@ORM\UniqueConstraint(name="strProductCode", columns={"strProductCode"})})
 * @ORM\Entity
 * @Assert\Expression(
 *     "this.getCost() >= 5 or this.getStock() >= 10",
 *     message="Any stock item which costs less that $5 and has less than 10 stock will not be imported", groups={"costAndStockConstraint"}
 * )
 */
class Product
{

    /**
     * @var integer
     *
     * @ORM\Column(name="intProductDataId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="dbProductCost", type="float")
     *
     * @Assert\NotBlank(message="Cost should not be blank")
     * @Assert\Type(type="numeric", message="Cost must be numeric and has type float")
     * @Assert\LessThan(value=1000, message="Cost should be less then 1000")
     */
    private $cost;

    /**
     * @var integer
     *
     * @ORM\Column(name="intProductStock", type="integer")
     * @Assert\NotBlank(message="Stock should not be blank")
     * @Assert\Type(type="numeric", message="Stock must be of type integer")
     *
     */
    private $stock;
    /**
     * @var string
     *
     * @ORM\Column(name="strProductName", type="string", length=50, nullable=false)
     *
     *
     * @Assert\NotBlank(message="Product name should not be blank");
     * @Assert\Type("string", message="The value {{ value }} is not a valid {{ type }}.")
     */
    private $name;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Product description should not be blank");
     * @ORM\Column(name="strProductDesc", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @Assert\NotBlank(message="Product code should not be blank")
     * @ORM\Column(name="strProductCode", type="string", length=10, nullable=false)
     */
    private $code;

    /**
     * @var \DateTime
     * @ORM\Column(name="dtmAdded", type="datetime", nullable=true)
     */
    private $addedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dtmDiscontinued", type="datetime", nullable=true)
     */
    private $discontinuedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="stmTimestamp", type="datetime", nullable=false)
     */
    private $timestamp;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return float
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param float $cost
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return \DateTime
     */
    public function getAddedAt()
    {
        return $this->addedAt;
    }

    /**
     * @param \DateTime $addedAt
     */
    public function setAddedAt($addedAt)
    {
        $this->addedAt = $addedAt;
    }
    /**
     * @return \DateTime
     */
    public function getDiscontinuedAt()
    {
        return $this->discontinuedAt;
    }

    /**
     * @param \DateTime $discontinuedAt
     */
    public function setDiscontinuedAt($discontinuedAt)
    {
        $this->discontinuedAt = $discontinuedAt;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        $resultStr = 'Code: ' . $this->code .
            ' Name: ' . $this->name .
            ' Desc: ' . $this->description .
            ' Cost: ' . $this->cost .
            ' Stock:' . $this->stock;
        if ($this->discontinuedAt !== null) {
            $resultStr .= ' DiscontinuedAt' . $this->discontinuedAt->format('Y-m-d H:i:s');
        }
        if ($this->addedAt !== null) {
            $resultStr .= ' Add at ' . $this->addedAt->format('Y-m-d H:i:s');
        }

        return $resultStr;
    }
    public function __construct()
    {
        $this->addedAt = new \DateTime('now');
        $this->timestamp = new \DateTime('now');
    }
}


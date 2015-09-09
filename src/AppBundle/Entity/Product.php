<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="price_discounted", type="decimal")
     */
    private $price_discounted;

    /**
     * @var integer
     *
     * @ORM\Column(name="viewed_count", type="integer")
     */
    private $viewed_count;

    /**
     * @var integer
     *
     * @ORM\Column(name="sold_no", type="integer")
     */
    private $soldNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="inventory", type="integer")
     */
    private $inventory;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    /**
     * @var datetime
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string", length=255)
     */
    private $poster;

    /**
     * @var array
     *
     * @ORM\Column(name="image_link", type="array")
     */
    private $imageLink;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     **/
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="product")
     **/
    private $comments;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set imageLink
     *
     * @param array $imageLink
     * @return Product
     */
    public function setImageLink($imageLink)
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    /**
     * Get imageLink
     *
     * @return array 
     */
    public function getImageLink()
    {
        return $this->imageLink;
    }

    /**
     * Set soldNo
     *
     * @param integer $soldNo
     * @return Product
     */
    public function setSoldNo($soldNo)
    {
        $this->soldNo = $soldNo;

        return $this;
    }

    /**
     * Get soldNo
     *
     * @return integer 
     */
    public function getSoldNo()
    {
        return $this->soldNo;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comments
     *
     * @param \AppBundle\Entity\Comment $comments
     * @return Product
     */
    public function addComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \AppBundle\Entity\Comment $comments
     */
    public function removeComment(\AppBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set price_discounted
     *
     * @param string $priceDiscounted
     * @return Product
     */
    public function setPriceDiscounted($priceDiscounted)
    {
        $this->price_discounted = $priceDiscounted;

        return $this;
    }

    /**
     * Get price_discounted
     *
     * @return string 
     */
    public function getPriceDiscounted()
    {
        return $this->price_discounted;
    }

    /**
     * Set viewed_count
     *
     * @param integer $viewedCount
     * @return Product
     */
    public function setViewedCount($viewedCount)
    {
        $this->viewed_count = $viewedCount;

        return $this;
    }

    /**
     * Get viewed_count
     *
     * @return integer 
     */
    public function getViewedCount()
    {
        return $this->viewed_count;
    }

    /**
     * Set inventory
     *
     * @param integer $inventory
     * @return Product
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return integer 
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /** 
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function UpdatePreUpdate()
    {
        $this->updateAt =  new \DateTime();
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     * @return Product
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime 
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set poster
     *
     * @param string $poster
     * @return Product
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Get poster
     *
     * @return string 
     */
    public function getPoster()
    {
        return $this->poster;
    }
}

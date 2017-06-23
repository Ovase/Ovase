<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;
    
    /**
     * @Assert\File(maxSize = "10M")
     * 
     * @var File
     */
    private $file;

    /**
     * Many images have one product
     * 
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Attachment
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
    
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return File
     */
    public function setFile(File $file = null) {
        $this->file = $file;
        if ($file) {
            // 
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Image
     */
    public function setProduct(\AppBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }
}

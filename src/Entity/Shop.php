<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShopRepository")
 */
class Shop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(name="map_link", type="string", length=255)
     */
    private $mapLink;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="District",
     *     inversedBy="shops"
     * )
     * @ORM\JoinColumn(
     *     name="district_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE",
     *     nullable=false
     * )
     */
    private $district;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBranded;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMapLink(): ?string
    {
        return $this->mapLink;
    }

    public function setMapLink(string $mapLink): self
    {
        $this->mapLink = $mapLink;

        return $this;
    }

    public function getDistrict(): ?District
    {
        return $this->district;
    }

    public function setDistrict(?District $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getIsBranded(): ?bool
    {
        return $this->isBranded;
    }

    public function setIsBranded(bool $isBranded): self
    {
        $this->isBranded = $isBranded;

        return $this;
    }
}

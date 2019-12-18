<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VacancyRepository")
 */
class Vacancy
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(
     *    targetEntity="ResponseVacancy",
     *    mappedBy="vacancy",
     *    cascade={"persist","remove"}
     * )
     *
     * @var ArrayCollection
     */
    private $responses;

    public function __construct()
    {
        $this->responses = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ResponseVacancy[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(ResponseVacancy $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setVacancyId($this);
        }

        return $this;
    }

    public function removeResponse(ResponseVacancy $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getVacancyId() === $this) {
                $response->setVacancyId(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\CountryRepository;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"security"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=CorporateBondSecurity::class, mappedBy="country", orphanRemoval=true)
     */
    private $corporateBondSecurities;

    public function __construct()
    {
        $this->corporateBondSecurities = new ArrayCollection();
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

    /**
     * @return Collection|CorporateBondSecurity[]
     */
    public function getCorporateBondSecurities(): Collection
    {
        return $this->corporateBondSecurities;
    }

    public function addCorporateBondSecurity(CorporateBondSecurity $corporateBondSecurity): self
    {
        if (!$this->corporateBondSecurities->contains($corporateBondSecurity)) {
            $this->corporateBondSecurities[] = $corporateBondSecurity;
            $corporateBondSecurity->setCountry($this);
        }

        return $this;
    }

    public function removeCorporateBondSecurity(CorporateBondSecurity $corporateBondSecurity): self
    {
        if ($this->corporateBondSecurities->removeElement($corporateBondSecurity)) {
            // set the owning side to null (unless already changed)
            if ($corporateBondSecurity->getCountry() === $this) {
                $corporateBondSecurity->setCountry(null);
            }
        }

        return $this;
    }
}

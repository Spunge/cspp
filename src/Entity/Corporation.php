<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use App\Repository\CorporationRepository;

/**
 * @ORM\Entity(repositoryClass=CorporationRepository::class)
 */
class Corporation
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
     * @ORM\OneToMany(targetEntity=CorporateBondSecurity::class, mappedBy="issuer", orphanRemoval=true)
     */
    private $corporateBondSecurities;

    /**
     * @Groups({"security"})
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

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
            $corporateBondSecurity->setIssuer($this);
        }

        return $this;
    }

    public function removeCorporateBondSecurity(CorporateBondSecurity $corporateBondSecurity): self
    {
        if ($this->corporateBondSecurities->removeElement($corporateBondSecurity)) {
            // set the owning side to null (unless already changed)
            if ($corporateBondSecurity->getIssuer() === $this) {
                $corporateBondSecurity->setIssuer(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}

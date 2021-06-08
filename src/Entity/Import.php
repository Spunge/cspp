<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\ImportRepository;

/**
 * @ORM\Entity(repositoryClass=ImportRepository::class)
 */
class Import
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"import"})
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @Groups({"import"})
     * @ORM\ManyToMany(targetEntity=CorporateBondSecurity::class, mappedBy="imports")
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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
            $corporateBondSecurity->addImport($this);
        }

        return $this;
    }

    public function removeCorporateBondSecurity(CorporateBondSecurity $corporateBondSecurity): self
    {
        if ($this->corporateBondSecurities->removeElement($corporateBondSecurity)) {
            $corporateBondSecurity->removeImport($this);
        }

        return $this;
    }
}

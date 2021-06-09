<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\CorporateBondSecurityRepository;

/**
 * @ORM\Entity(repositoryClass=CorporateBondSecurityRepository::class)
 */
class CorporateBondSecurity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"security", "import", "corporation"})
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $isin;

    /**
     * @Groups({"security", "import", "corporation"})
     * @ORM\Column(type="date", nullable=true)
     */
    private $maturityDate;

    /**
     * @Groups({"security", "import", "corporation"})
     * @ORM\Column(type="float", nullable=true)
     */
    private $couponRate;

    /**
     * @ORM\ManyToMany(targetEntity=Import::class, inversedBy="corporateBondSecurities")
     */
    private $imports;

    /**
     * @Groups({"security", "import"})
     * @ORM\ManyToOne(targetEntity=Corporation::class, inversedBy="corporateBondSecurities")
     * @ORM\JoinColumn(nullable=true)
     */
    private $issuer;

    /**
     * @Groups({"security", "import", "corporation"})
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="corporateBondSecurities")
     * @ORM\JoinColumn(nullable=true)
     */
    private $country;

    /**
     * @Groups({"security", "import", "corporation"})
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_floating;

    public function __construct()
    {
        $this->imports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsin(): ?string
    {
        return $this->isin;
    }

    public function setIsin(string $isin): self
    {
        $this->isin = $isin;

        return $this;
    }

    public function getMaturityDate(): ?\DateTimeInterface
    {
        return $this->maturityDate;
    }

    public function setMaturityDate(\DateTimeInterface $maturityDate): self
    {
        $this->maturityDate = $maturityDate;

        return $this;
    }

    public function getCouponRate(): ?float
    {
        return $this->couponRate;
    }

    public function setCouponRate(float $couponRate): self
    {
        $this->couponRate = $couponRate;

        return $this;
    }

    /**
     * @return Collection|Import[]
     */
    public function getImports(): Collection
    {
        return $this->imports;
    }

    public function addImport(Import $import): self
    {
        if (!$this->imports->contains($import)) {
            $this->imports[] = $import;
        }

        return $this;
    }

    public function removeImport(Import $import): self
    {
        $this->imports->removeElement($import);

        return $this;
    }

    public function getIssuer(): ?Corporation
    {
        return $this->issuer;
    }

    public function setIssuer(?Corporation $issuer): self
    {
        $this->issuer = $issuer;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getIsFloating(): ?bool
    {
        return $this->is_floating;
    }

    public function setIsFloating(bool $is_floating): self
    {
        $this->is_floating = $is_floating;

        return $this;
    }
}

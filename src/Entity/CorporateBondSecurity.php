<?php

namespace App\Entity;

use App\Repository\CorporateBondSecurityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=2)
     */
    private $ncb;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $isin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $issuer;

    /**
     * @ORM\Column(type="date")
     */
    private $maturityDate;

    /**
     * @ORM\Column(type="float")
     */
    private $couponRate;

    /**
     * @ORM\ManyToMany(targetEntity=Import::class, inversedBy="corporateBondSecurities")
     */
    private $imports;

    public function __construct()
    {
        $this->imports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNcb(): ?string
    {
        return $this->ncb;
    }

    public function setNcb(string $ncb): self
    {
        $this->ncb = $ncb;

        return $this;
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

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function setIssuer(string $issuer): self
    {
        $this->issuer = $issuer;

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
}

<?php

namespace App\Entity;

use App\Repository\Parse2ExampleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Parse2ExampleRepository::class)]
class Parse2Example
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: CategorySite::class, inversedBy: 'Parse2Examples')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorySite;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ville;
    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $telephone;

    #[ORM\Column(type: 'string', length: 255)]
    private $urlOffre;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $details;

    #[ORM\Column(type: 'string', nullable: true, length: 255)]
    private $region;

    #[ORM\Column(type: 'string', nullable: true, length: 255)]
    private $departement;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $date_publication;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\Column(type: 'text', nullable: true)]
    private $images;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $typeDeBien;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $typeDeVente;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $surface;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $surfaceDuTerrain;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pieces;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $energie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ges;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $vente;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $etages;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $etage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $parking;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $charges;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $meuble;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $reference;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $honoraires;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $chambres;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorySite(): ?CategorySite
    {
        return $this->categorySite;
    }

    public function setCategorySite(?CategorySite $categorySite): self
    {
        $this->categorySite = $categorySite;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUrlOffre(): ?string
    {
        return $this->urlOffre;
    }

    public function setUrlOffre(string $urlOffre): self
    {
        $this->urlOffre = $urlOffre;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDetails(): ?bool
    {
        return $this->details;
    }

    public function setDetails(bool $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(?\DateTimeInterface $date_publication): self
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getTypeDeBien(): ?string
    {
        return $this->typeDeBien;
    }

    public function setTypeDeBien(?string $typeDeBien): self
    {
        $this->typeDeBien = $typeDeBien;

        return $this;
    }

    public function getTypeDeVente(): ?string
    {
        return $this->typeDeVente;
    }

    public function setTypeDeVente(?string $typeDeVente): self
    {
        $this->typeDeVente = $typeDeVente;

        return $this;
    }

    public function getSurface(): ?string
    {
        return $this->surface;
    }

    public function setSurface(?string $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getSurfaceDuTerrain(): ?string
    {
        return $this->surfaceDuTerrain;
    }

    public function setSurfaceDuTerrain(?string $surfaceDuTerrain): self
    {
        $this->surfaceDuTerrain = $surfaceDuTerrain;

        return $this;
    }

    public function getPieces(): ?string
    {
        return $this->pieces;
    }

    public function setPieces(?string $pieces): self
    {
        $this->pieces = $pieces;

        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(?string $energie): self
    {
        $this->energie = $energie;

        return $this;
    }

    public function getGes(): ?string
    {
        return $this->ges;
    }

    public function setGes(?string $ges): self
    {
        $this->ges = $ges;

        return $this;
    }

    public function getVente(): ?string
    {
        return $this->vente;
    }

    public function setVente(?string $vente): self
    {
        $this->vente = $vente;

        return $this;
    }

    public function getEtages(): ?string
    {
        return $this->etages;
    }

    public function setEtages(?string $etages): self
    {
        $this->etages = $etages;

        return $this;
    }

    public function getEtage(): ?string
    {
        return $this->etage;
    }

    public function setEtage(?string $etage): self
    {
        $this->etage = $etage;

        return $this;
    }

    public function getParking(): ?string
    {
        return $this->parking;
    }

    public function setParking(?string $parking): self
    {
        $this->parking = $parking;

        return $this;
    }

    public function getCharges(): ?string
    {
        return $this->charges;
    }

    public function setCharges(?string $charges): self
    {
        $this->charges = $charges;

        return $this;
    }

    public function getMeuble(): ?string
    {
        return $this->meuble;
    }

    public function setMeuble(?string $meuble): self
    {
        $this->meuble = $meuble;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getHonoraires(): ?string
    {
        return $this->honoraires;
    }

    public function setHonoraires(?string $honoraires): self
    {
        $this->honoraires = $honoraires;

        return $this;
    }

    public function getChambres(): ?string
    {
        return $this->chambres;
    }

    public function setChambres(?string $chambres): self
    {
        $this->chambres = $chambres;

        return $this;
    }
}

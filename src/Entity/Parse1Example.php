<?php

namespace App\Entity;

use App\Repository\Parse1ExampleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Parse1ExampleRepository::class)]
class Parse1Example
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: CategorySite::class, inversedBy: 'parse1s')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorySite;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $ville;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $marque;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $modele;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $anneeModele;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $dateCirculation;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $kilometrage;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $carburant;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $boiteVitesse;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $vehiculeType;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $couleur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $portes;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $places;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $puissanceFiscale;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $puissanceDIN;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $permis;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $LOALLD;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $piecesDetachees;

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

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(?string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(?string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getAnneeModele(): ?string
    {
        return $this->anneeModele;
    }

    public function setAnneeModele(?string $anneeModele): self
    {
        $this->anneeModele = $anneeModele;

        return $this;
    }

    public function getDateCirculation(): ?\DateTimeInterface
    {
        return $this->dateCirculation;
    }

    public function setDateCirculation(?\DateTimeInterface $dateCirculation): self
    {
        $this->dateCirculation = $dateCirculation;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getCarburant(): ?string
    {
        return $this->carburant;
    }

    public function setCarburant(?string $carburant): self
    {
        $this->carburant = $carburant;

        return $this;
    }

    public function getBoiteVitesse(): ?string
    {
        return $this->boiteVitesse;
    }

    public function setBoiteVitesse(?string $boiteVitesse): self
    {
        $this->boiteVitesse = $boiteVitesse;

        return $this;
    }

    public function getVehiculeType(): ?string
    {
        return $this->vehiculeType;
    }

    public function setVehiculeType(?string $vehiculeType): self
    {
        $this->vehiculeType = $vehiculeType;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(?string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getPortes(): ?string
    {
        return $this->portes;
    }

    public function setPortes(?string $portes): self
    {
        $this->portes = $portes;

        return $this;
    }

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getPuissanceFiscale(): ?string
    {
        return $this->puissanceFiscale;
    }

    public function setPuissanceFiscale(?string $puissanceFiscale): self
    {
        $this->puissanceFiscale = $puissanceFiscale;

        return $this;
    }

    public function getPuissanceDIN(): ?string
    {
        return $this->puissanceDIN;
    }

    public function setPuissanceDIN(?string $puissanceDIN): self
    {
        $this->puissanceDIN = $puissanceDIN;

        return $this;
    }

    public function getPermis(): ?int
    {
        return $this->permis;
    }

    public function setPermis(int $permis): self
    {
        $this->permis = $permis;

        return $this;
    }

    public function getLOALLD(): ?bool
    {
        return $this->LOALLD;
    }

    public function setLOALLD(bool $LOALLD): self
    {
        $this->LOALLD = $LOALLD;

        return $this;
    }

    public function getPiecesDetachees(): ?string
    {
        return $this->piecesDetachees;
    }

    public function setPiecesDetachees(?string $piecesDetachees): self
    {
        $this->piecesDetachees = $piecesDetachees;

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
}

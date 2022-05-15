<?php

namespace App\Entity;

use App\Repository\CategorySiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorySiteRepository::class)]
class CategorySite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Site::class, inversedBy: 'categories')]
    #[ORM\JoinColumn(nullable: false)]
    private $site;

    #[ORM\Column(type: 'string', length: 255)]
    private $urlCategorie;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToMany(mappedBy: 'categorySite', targetEntity: Parse1::class, orphanRemoval: true)]
    private $parse1s;

    #[ORM\Column(type: 'integer')]
    private $parseList;

    public function __construct()
    {
        $this->parse1s = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getUrlCategorie(): ?string
    {
        return $this->urlCategorie;
    }

    public function setUrlCategorie(string $urlCategorie): self
    {
        $this->urlCategorie = $urlCategorie;

        return $this;
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
     * @return Collection<int, Parse1>
     */
    public function getParse1s(): Collection
    {
        return $this->parse1s;
    }

    public function addParse1(Parse1 $parse1): self
    {
        if (!$this->parse1s->contains($parse1)) {
            $this->parse1s[] = $parse1;
            $parse1->setCategorySite($this);
        }

        return $this;
    }

    public function removeParse1(Parse1 $parse1): self
    {
        if ($this->parse1s->removeElement($parse1)) {
            // set the owning side to null (unless already changed)
            if ($parse1->getCategorySite() === $this) {
                $parse1->setCategorySite(null);
            }
        }

        return $this;
    }

    public function getParseList(): ?int
    {
        return $this->parseList;
    }

    public function setParseList(int $parseList): self
    {
        $this->parseList = $parseList;

        return $this;
    }
}

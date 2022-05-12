<?php

namespace App\Entity;

use App\Repository\DossierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: DossierRepository::class)]
#[ApiResource]
class Dossier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $numDossier;

    #[ORM\OneToMany(mappedBy: 'dossier', targetEntity: InfosPatients::class)]
    private $infosPatients;

    #[ORM\OneToMany(mappedBy: 'dossier', targetEntity: Examen::class)]
    private $examens;

    public function __construct()
    {
        $this->infosPatients = new ArrayCollection();
        $this->examens = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumDossier(): ?int
    {
        return $this->numDossier;
    }

    public function setNumDossier(int $numDossier): self
    {
        $this->numDossier = $numDossier;

        return $this;
    }

    /**
     * @return Collection<int, InfosPatients>
     */
    public function getInfosPatients(): Collection
    {
        return $this->infosPatients;
    }

    public function addInfosPatient(InfosPatients $infosPatient): self
    {
        if (!$this->infosPatients->contains($infosPatient)) {
            $this->infosPatients[] = $infosPatient;
            $infosPatient->setDossier($this);
        }

        return $this;
    }

    public function removeInfosPatient(InfosPatients $infosPatient): self
    {
        if ($this->infosPatients->removeElement($infosPatient)) {
            // set the owning side to null (unless already changed)
            if ($infosPatient->getDossier() === $this) {
                $infosPatient->setDossier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Examen>
     */
    public function getExamens(): Collection
    {
        return $this->examens;
    }

    public function addExamen(Examen $examen): self
    {
        if (!$this->examens->contains($examen)) {
            $this->examens[] = $examen;
            $examen->setDossier($this);
        }

        return $this;
    }

    public function removeExamen(Examen $examen): self
    {
        if ($this->examens->removeElement($examen)) {
            // set the owning side to null (unless already changed)
            if ($examen->getDossier() === $this) {
                $examen->setDossier(null);
            }
        }

        return $this;
    }
}

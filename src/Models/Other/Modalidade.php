<?php
namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cg_modalidade")
 */
class Modalidade
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $nome;

    /**
     * @ORM\OneToMany(targetEntity="Fase", mappedBy="modalidade", cascade={"remove"})
     */
    public $fases;

    public function __construct()
    {
        $this->fases = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getFases()
    {
        return $this->fases->toArray();
    }

    public function addFase(Fase $fase)
    {
        if (!$this->fases->contains($fase)) {
            $this->fases->add($fase);
        }

        return $this;
    }

    public function removeFase(Fase $fase)
    {
        if ($this->fases->contains($fase)) {
            $this->fases->removeElement($fase);
        }

        return $this;
    }

    public function getTipos()
    {
        return array_map(
            function ($fase) {
                return $fase->getTipo();
            },
            $this->fases->toArray()
        );
    }

    public function getValues()
    {
        return get_object_vars($this);
    }
}

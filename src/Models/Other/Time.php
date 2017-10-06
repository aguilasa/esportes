<?php
namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="cg_time")
 */
class Time
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
     * @ORM\OneToMany(targetEntity="Jogo", mappedBy="time", cascade={"remove"})
     */
    public $jogos;

    public function __construct()
    {
        $this->jogos = new ArrayCollection();
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

    public function getJogos()
    {
        return $this->jogos->toArray();
    }

    public function addJogo(Jogo $jogo)
    {
        if (!$this->jogos->contains($jogo)) {
            $this->jogos->add($jogo);
        }

        return $this;
    }

    public function removeJogo(Jogo $jogo)
    {
        if ($this->jogos->contains($jogo)) {
            $this->jogos->removeElement($jogo);
        }

        return $this;
    }

    public function getValues()
    {
        return get_object_vars($this);
    }
}

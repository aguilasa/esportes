<?php
namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="integer")
     */
    public $futebol;

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

    public function getFutebol()
    {
        return $this->futebol;
    }

    public function setFutebol($futebol)
    {
        $this->futebol = $futebol;
        return $this;
    }

    public function getValues()
    {
        return get_object_vars($this);
    }
}

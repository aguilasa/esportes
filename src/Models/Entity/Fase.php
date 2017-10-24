<?php
namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cg_fase")
 */
class Fase
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Modalidade", fetch="EAGER")
     * @ORM\JoinColumn(name="modalidade_id", referencedColumnName="id", nullable=FALSE)
     */
    public $modalidade;

    /**
     * @ORM\ManyToOne(targetEntity="Tipo", fetch="EAGER")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id", nullable=FALSE)
     */
    public $tipo;
	
	/**
     * @ORM\Column(type="string")
     */
    public $nome;

    public function getId()
    {
        return $this->id;
    }

    public function getModalidade()
    {
        return $this->modalidade;
    }

    public function setModalidade(Modalidade $modalidade = null)
    {
        $this->modalidade = $modalidade;
        return $this;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo(Tipo $tipo = null)
    {
        $this->tipo = $tipo;
        return $this;
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

    public function getValues()
    {
        return get_object_vars($this);
    }
}

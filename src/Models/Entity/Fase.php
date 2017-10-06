<?php
namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fase
 *
 * @ORM\Table(name="cg_fase", indexes={@ORM\Index(name="modalidade_id", columns={"modalidade_id"}), @ORM\Index(name="tipo_id", columns={"tipo_id"})})
 * @ORM\Entity
 */
class Fase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=100, nullable=true)
     */
    public $nome;

    /**
     * @var Modalidade
     *
     * @ORM\ManyToOne(targetEntity="Modalidade", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modalidade_id", referencedColumnName="id")
     * })
     */
    public $modalidade;

    /**
     * @var \Tipo
     *
     * @ORM\ManyToOne(targetEntity="Tipo", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipo_id", referencedColumnName="id")
     * })
     */
    public $tipo;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Fase
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set modalidade
     *
     * @param Modalidade $modalidade
     *
     * @return Fase
     */
    public function setModalidade(Modalidade $modalidade = null)
    {
        $this->modalidade = $modalidade;

        return $this;
    }

    /**
     * Get modalidade
     *
     * @return Modalidade
     */
    public function getModalidade()
    {
        return $this->modalidade;
    }

    /**
     * Set tipo
     *
     * @param Tipo $tipo
     *
     * @return Fase
     */
    public function setTipo(Tipo $tipo = null)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return Tipo
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    public function getValues() {
        return get_object_vars($this);
    }
}


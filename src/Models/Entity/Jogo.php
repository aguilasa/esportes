<?php
namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cg_jogo")
 */
class Jogo
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\ManyToOne(targetEntity="Fase", fetch="EAGER")
     * @ORM\JoinColumn(name="fase_id", referencedColumnName="id", nullable=FALSE)
     */
    public $fase;

    /**
     * @ORM\ManyToOne(targetEntity="Situacao", fetch="EAGER")
     * @ORM\JoinColumn(name="situacao_id", referencedColumnName="id", nullable=FALSE)
     */
    public $situacao;

    /**
     * @ORM\ManyToOne(targetEntity="Time", fetch="EAGER")
     * @ORM\JoinColumn(name="time1", referencedColumnName="id", nullable=FALSE)
     */
    public $time1;
     
    /**
    * @ORM\ManyToOne(targetEntity="Time", fetch="EAGER")
    * @ORM\JoinColumn(name="time2", referencedColumnName="id", nullable=FALSE)
    */
    public $time2;
    
    /**
     * @ORM\Column(type="integer")
     */
    public $ordem;

    /**
     * @ORM\Column(type="integer")
     */
    public $placar1;

     /**
     * @ORM\Column(type="integer")
     */
    public $penalti1;

    /**
     * @ORM\Column(type="integer")
     */
    public $placar2;

     /**
     * @ORM\Column(type="integer")
     */
    public $penalti2;

    public function getId()
    {
        return $this->id;
    }

    public function getFase()
    {
        return $this->fase;
    }

    public function setFase(Fase $fase = null)
    {
        $this->fase = $fase;
        return $this;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function setSituacao(Situacao $situacao = null)
    {
        $this->situacao = $situacao;
        return $this;
    }

    public function getTime1()
    {
        return $this->time1;
    }

    public function setTime1(Time $time1 = null)
    {
        $this->time1 = $time1;
        return $this;
    }

    public function getTime2()
    {
        return $this->time2;
    }

    public function setTime2(Time $time2 = null)
    {
        $this->time2 = $time2;
        return $this;
    }

    public function getOrdem()
    {
        return $this->ordem;
    }

    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    public function getPlacar1()
    {
        return $this->placar1;
    }

    public function setPlacar1($placar1)
    {
        $this->placar1 = $placar1;
        return $this;
    }

    public function getPenalti1()
    {
        return $this->penalti1;
    }

    public function setPenalti1($penalti1)
    {
        $this->penalti1 = $penalti1;
        return $this;
    }

    public function getPlacar2()
    {
        return $this->placar2;
    }

    public function setPlacar2($placar2)
    {
        $this->placar2 = $placar2;
        return $this;
    }

    public function getPenalti2()
    {
        return $this->penalti2;
    }

    public function setPenalti2($penalti2)
    {
        $this->penalti2 = $penalti2;
        return $this;
    }

    public function getValues()
    {
        return get_object_vars($this);
    }
}

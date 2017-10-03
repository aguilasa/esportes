<?php

namespace App\Models\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jogo
 *
 * @ORM\Table(name="cg_jogo", indexes={@ORM\Index(name="fase_id", columns={"fase_id"}), @ORM\Index(name="time_1", columns={"time_1"}), @ORM\Index(name="time_2", columns={"time_2"}), @ORM\Index(name="situacao_id", columns={"situacao_id"})})
 * @ORM\Entity
 */
class Jogo
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
     * @var integer
     *
     * @ORM\Column(name="ordem", type="integer", nullable=true)
     */
    public $ordem;

    /**
     * @var integer
     *
     * @ORM\Column(name="placar_1", type="integer", nullable=true)
     */
    public $placar1;

    /**
     * @var integer
     *
     * @ORM\Column(name="penalti_1", type="integer", nullable=true)
     */
    public $penalti1;

    /**
     * @var integer
     *
     * @ORM\Column(name="placar_2", type="integer", nullable=true)
     */
    public $placar2;

    /**
     * @var integer
     *
     * @ORM\Column(name="penalti_2", type="integer", nullable=true)
     */
    public $penalti2;

    /**
     * @var \Fase
     *
     * @ORM\ManyToOne(targetEntity="Fase")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fase_id", referencedColumnName="id")
     * })
     */
    public $fase;

    /**
     * @var \Time
     *
     * @ORM\ManyToOne(targetEntity="Time")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="time_1", referencedColumnName="id")
     * })
     */
    public $time1;

    /**
     * @var \Time
     *
     * @ORM\ManyToOne(targetEntity="Time")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="time_2", referencedColumnName="id")
     * })
     */
    public $time2;

    /**
     * @var \Situacao
     *
     * @ORM\ManyToOne(targetEntity="Situacao")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="situacao_id", referencedColumnName="id")
     * })
     */
    public $situacao;


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
     * Set ordem
     *
     * @param integer $ordem
     *
     * @return Jogo
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;

        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set placar1
     *
     * @param integer $placar1
     *
     * @return Jogo
     */
    public function setPlacar1($placar1)
    {
        $this->placar1 = $placar1;

        return $this;
    }

    /**
     * Get placar1
     *
     * @return integer
     */
    public function getPlacar1()
    {
        return $this->placar1;
    }

    /**
     * Set penalti1
     *
     * @param integer $penalti1
     *
     * @return Jogo
     */
    public function setPenalti1($penalti1)
    {
        $this->penalti1 = $penalti1;

        return $this;
    }

    /**
     * Get penalti1
     *
     * @return integer
     */
    public function getPenalti1()
    {
        return $this->penalti1;
    }

    /**
     * Set placar2
     *
     * @param integer $placar2
     *
     * @return Jogo
     */
    public function setPlacar2($placar2)
    {
        $this->placar2 = $placar2;

        return $this;
    }

    /**
     * Get placar2
     *
     * @return integer
     */
    public function getPlacar2()
    {
        return $this->placar2;
    }

    /**
     * Set penalti2
     *
     * @param integer $penalti2
     *
     * @return Jogo
     */
    public function setPenalti2($penalti2)
    {
        $this->penalti2 = $penalti2;

        return $this;
    }

    /**
     * Get penalti2
     *
     * @return integer
     */
    public function getPenalti2()
    {
        return $this->penalti2;
    }

    /**
     * Set fase
     *
     * @param \Fase $fase
     *
     * @return Jogo
     */
    public function setFase(\Fase $fase = null)
    {
        $this->fase = $fase;

        return $this;
    }

    /**
     * Get fase
     *
     * @return \Fase
     */
    public function getFase()
    {
        return $this->fase;
    }

    /**
     * Set time1
     *
     * @param \Time $time1
     *
     * @return Jogo
     */
    public function setTime1(\Time $time1 = null)
    {
        $this->time1 = $time1;

        return $this;
    }

    /**
     * Get time1
     *
     * @return \Time
     */
    public function getTime1()
    {
        return $this->time1;
    }

    /**
     * Set time2
     *
     * @param \Time $time2
     *
     * @return Jogo
     */
    public function setTime2(\Time $time2 = null)
    {
        $this->time2 = $time2;

        return $this;
    }

    /**
     * Get time2
     *
     * @return \Time
     */
    public function getTime2()
    {
        return $this->time2;
    }

    /**
     * Set situacao
     *
     * @param \Situacao $situacao
     *
     * @return Jogo
     */
    public function setSituacao(\Situacao $situacao = null)
    {
        $this->situacao = $situacao;

        return $this;
    }

    /**
     * Get situacao
     *
     * @return \Situacao
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    public function getValues() {
        return get_object_vars($this);
    }
}


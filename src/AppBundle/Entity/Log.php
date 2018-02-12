<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * Log
 *
 * @ORM\Table(name="log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LogRepository")
 */
class Log
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime
     *
     * @ORM\Column(name="data", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="Chamado")
     * @ORM\JoinColumn(name="chamado_id", referencedColumnName="id")
     */
    protected $chamado;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="anterior_id", referencedColumnName="id")
     */
    protected $anterior;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="atual_id", referencedColumnName="id")
     */
    protected $atual;

    /**
     * @var string
     *
     * @ORM\Column(name="que", type="string")
     */
    protected $que;

    /**
     * @var string
     *
     * @ORM\Column(name="como", type="text")
     */
    protected $como;

    public function __construct()
    {
        $this->data = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Log
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set chamado
     *
     * @param integer $chamado
     *
     * @return Log
     */
    public function setChamado($chamado = null)
    {
        $this->chamado = $chamado;

        return $this;
    }

    /**
     * Get chamado
     *
     * @return Chamado
     */
    public function getChamado()
    {
        return $this->chamado;
    }

    /**
     * Set anterior
     *
     * @param integer $anterior
     *
     * @return Log
     */
    public function setAnterior($anterior = null)
    {
        $this->anterior = $anterior;

        return $this;
    }

    /**
     * Get anterior
     *
     * @return Status
     */
    public function getAnterior()
    {
        return $this->anterior;
    }

    /**
     * Set atual
     *
     * @param Integer $atual
     *
     * @return Log
     */
    public function setAtual($atual = null)
    {
        $this->atual = $atual;

        return $this;
    }

    /**
     * Get atual
     *
     * @return Status
     */
    public function getAtual()
    {
        return $this->atual;
    }

    /**
     * Set que
     *
     * @param string $que
     *
     * @return Log
     */
    public function setQue($que)
    {
        $this->que = $que;

        return $this;
    }

    /**
     * Get que
     *
     * @return string
     */
    public function getQue()
    {
        return $this->que;
    }

    /**
     * Set como
     *
     * @param string $como
     *
     * @return Log
     */
    public function setComo($como)
    {
        $this->como = $como;

        return $this;
    }

    /**
     * Get como
     *
     * @return string
     */
    public function getComo()
    {
        return $this->como;
    }
}

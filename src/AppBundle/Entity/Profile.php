<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
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
     * @var string|null
     *
     * @ORM\Column(name="nome", type="string", length=100, nullable=true)
     */
    private $nome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="sobrenome", type="string", length=100, nullable=true)
     */
    private $sobrenome;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefone", type="string", length=25, nullable=true)
     */
    private $telefone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="celular", type="string", length=25, nullable=true)
     */
    private $celular;

    /**
     * @var string|null
     *
     * @ORM\Column(name="menssagem", type="text", nullable=true)
     */
    private $menssagem;

    /**
     * @var string|null
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=true)
     */
    private $titulo;

    /**
     * Cada perfil tiene un usuario.
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;


    private function nomeCompleto()
    {
        $nomeCompleto = $this->nome.' '.$this->sobrenome;

        return $nomeCompleto;
    }

    public function getNomeCompleto()
    {
        return $this->nomeCompleto();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome.
     *
     * @param string|null $nome
     *
     * @return Profile
     */
    public function setNome($nome = null)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome.
     *
     * @return string|null
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set sobrenome.
     *
     * @param string|null $sobrenome
     *
     * @return Profile
     */
    public function setSobrenome($sobrenome = null)
    {
        $this->sobrenome = $sobrenome;

        return $this;
    }

    /**
     * Get sobrenome.
     *
     * @return string|null
     */
    public function getSobrenome()
    {
        return $this->sobrenome;
    }

    /**
     * Set telefone.
     *
     * @param string|null $telefone
     *
     * @return Profile
     */
    public function setTelefone($telefone = null)
    {
        $this->telefone = $telefone;

        return $this;
    }

    /**
     * Get telefone.
     *
     * @return string|null
     */
    public function getTelefone()
    {
        return $this->telefone;
    }

    /**
     * Set celular.
     *
     * @param string|null $celular
     *
     * @return Profile
     */
    public function setCelular($celular = null)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular.
     *
     * @return string|null
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set menssagem.
     *
     * @param string|null $menssagem
     *
     * @return Profile
     */
    public function setMenssagem($menssagem = null)
    {
        $this->menssagem = $menssagem;

        return $this;
    }

    /**
     * Get menssagem.
     *
     * @return string|null
     */
    public function getMenssagem()
    {
        return $this->menssagem;
    }

    /**
     * Set titulo.
     *
     * @param string|null $titulo
     *
     * @return Profile
     */
    public function setTitulo($titulo = null)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo.
     *
     * @return string|null
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User|null $user
     *
     * @return Profile
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getUser()
    {
        return $this->user;
    }
}

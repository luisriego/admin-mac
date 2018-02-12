<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=55, unique=true, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="sobrenome", type="string", length=255, unique=true, nullable=true)
     */
    private $sobrenome;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=100, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="usuarios")
     * @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     */
    protected $empresa;

    /**
     * @ORM\OneToOne(targetEntity="Profile")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     */
    private $profile;
    
    /**
     * @ORM\OneToOne(targetEntity="Endereco")
     * @ORM\JoinColumn(name="endereco_id", referencedColumnName="id")
     */
    private $endereco;

    public function __construct()
    {
        parent::__construct();
    }

    private function nomeCompleto()
    {
        $nomeCompleto = $this->nome.' '.$this->sobrenome;

        if ($nomeCompleto == '') {
            $nomeCompleto = $this->username;
        }
        return $nomeCompleto;
    }

    public function getNomeCompleto()
    {
        return $this->nomeCompleto();
    }


    /**
     * Set nome.
     *
     * @param string|null $nome
     *
     * @return User
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
     * @return User
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
     * Set avatar.
     *
     * @param string|null $avatar
     *
     * @return User
     */
    public function setAvatar($avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar.
     *
     * @return string|null
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set empresa.
     *
     * @param \AppBundle\Entity\Cliente|null $empresa
     *
     * @return User
     */
    public function setEmpresa(\AppBundle\Entity\Cliente $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa.
     *
     * @return \AppBundle\Entity\Cliente|null
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set profile.
     *
     * @param \AppBundle\Entity\Profile|null $profile
     *
     * @return User
     */
    public function setProfile(\AppBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile.
     *
     * @return \AppBundle\Entity\Profile|null
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set endereco.
     *
     * @param \AppBundle\Entity\Endereco|null $endereco
     *
     * @return User
     */
    public function setEndereco(\AppBundle\Entity\Endereco $endereco = null)
    {
        $this->endereco = $endereco;

        return $this;
    }

    /**
     * Get endereco.
     *
     * @return \AppBundle\Entity\Endereco|null
     */
    public function getEndereco()
    {
        return $this->endereco;
    }
}

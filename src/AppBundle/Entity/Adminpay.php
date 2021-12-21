<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adminpay
 *
 * @ORM\Table(name="adminpay")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdminpayRepository")
 */
class Adminpay
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
     * @ORM\Column(name="mail", type="string", length=150, nullable=true)
     */
    private $mail;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="iduser", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $iduser;

    /**
     * @var \Coli
     *
     * @ORM\ManyToOne(targetEntity="AnnonceBundle\Entity\Coli")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="idcoli", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idcoli; 

    /**
     * @var int
     *
     * @ORM\Column(name="paiement", type="smallint", nullable=true)
     */
    private $paiement; 


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
     * Set mail.
     *
     * @param string|null $mail
     *
     * @return Adminpay
     */
    public function setMail($mail = null)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail.
     *
     * @return string|null
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set iduser.
     *
     * @param \AppBundle\Entity\User|null $iduser
     *
     * @return Adminpay
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set idcoli.
     *
     * @param \AnnonceBundle\Entity\Trajet|null $idcoli
     *
     * @return Adminpay
     */
    public function setIdcoli($idcoli)
    {
        $this->idcoli = $idcoli;

        return $this;
    }

    /**
     * Get idcoli.
     *
     * @return \AnnonceBundle\Entity\Trajet|null
     */
    public function getIdcoli()
    {
        return $this->idcoli;
    }

    /**
     * Set paiement.
     *
     * @param int $paiement
     *
     * @return Adminpay
     */
    public function setPaiement($paiement)
    {
        $this->paiement = $paiement;

        return $this;
    }

    /**
     * Get paiement.
     *
     * @return int
     */
    public function getPaiement()
    {
        return $this->paiement;
    }
}

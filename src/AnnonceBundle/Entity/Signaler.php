<?php

namespace AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signaler
 *
 * @ORM\Table(name="Signaler")
 * @ORM\Entity(repositoryClass="AnnonceBundle\Repository\SignalerRepository")
 */
class Signaler
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
     * @var \DateTime
     *
     * @ORM\Column(name="datesignaler", type="date")
     */
    private $datesignaler;

     public function __construct(){
        $this->datesignaler = new \DateTime('now');
    }

    /**
     * @var string
     *
     * @ORM\Column(name="raison", type="string", length=255)
     */
    private $raison;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idannonceur", referencedColumnName="id")
     * })
     */
    private $idannonceur;

    /**
     * @var \Trajet
     *
     * @ORM\ManyToOne(targetEntity="AnnonceBundle\Entity\Trajet")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idtrajet", referencedColumnName="id")
     * })
     */
    private $idtrajet;

    /**
     * @var \Coli
     *
     * @ORM\ManyToOne(targetEntity="AnnonceBundle\Entity\Coli")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcoli", referencedColumnName="id")
     * })
     */
    private $idcoli;



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
     * Set datesignaler
     *
     * @param \DateTime $datesignaler
     *
     * @return Signaler
     */
    public function setDatesignaler($datesignaler)
    {
        $this->datesignaler = $datesignaler;

        return $this;
    }

    /**
     * Get datesignaler
     *
     * @return \DateTime
     */
    public function getDatesignaler()
    {
        return $this->datesignaler;
    }

    /**
     * Set raison
     *
     * @param string $raison
     *
     * @return Signaler
     */
    public function setRaison($raison)
    {
        $this->raison = $raison;

        return $this;
    }

    /**
     * Get raison
     *
     * @return string
     */
    public function getRaison()
    {
        return $this->raison;
    }

    /**
     * Set idannonceur
     *
     * @param \AppBundle\Entity\User $idannonceur
     *
     * @return Signaler
     */
    public function setIdannonceur($idannonceur)
    {
        $this->idannonceur = $idannonceur;

        return $this;
    }

    /**
     * Get idannonceur
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdannonceur()
    {
        return $this->idannonceur;
    }

    /**
     * Set idtrajet
     *
     * @param \AnnonceBundle\Entity\Trajet $idtrajet
     *
     * @return Signaler
     */
    public function setIdtrajet($idtrajet)
    {
        $this->idtrajet = $idtrajet;

        return $this;
    }

    /**
     * Get idtrajet
     *
     * @return \AnnonceBundle\Entity\Trajet
     */
    public function getIdtrajet()
    {
        return $this->idtrajet;
    }

    /**
     * Set idcoli
     *
     * @param \AnnonceBundle\Entity\Coli $idcoli
     *
     * @return Signaler
     */
    public function setIdcoli($idcoli)
    {
        $this->idcoli = $idcoli;

        return $this;
    }

    /**
     * Get idcoli
     *
     * @return \AnnonceBundle\Entity\Coli
     */
    public function getIdcoli()
    {
        return $this->idcoli;
    }
}

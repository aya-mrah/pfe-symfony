<?php

namespace AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris")
 * @ORM\Entity(repositoryClass="AnnonceBundle\Repository\FavorisRepository")
 */
class Favoris
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
     * @ORM\Column(name="datefavoris", type="date")
     */
    private $datefavoris;
    public function __construct(){
        $this->datefavoris = new \DateTime('now');
    }

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
     *   @ORM\JoinColumn(name="idtrajet", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $idtrajet;

    /**
     * @var \Coli
     *
     * @ORM\ManyToOne(targetEntity="AnnonceBundle\Entity\Coli")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcoli", referencedColumnName="id",onDelete="CASCADE")
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
     * Set datefavoris
     *
     * @param \DateTime $datefavoris
     *
     * @return Favoris
     */
    public function setDatefavoris($datefavoris)
    {
        $this->datefavoris = $datefavoris;

        return $this;
    }

    /**
     * Get datefavoris
     *
     * @return \DateTime
     */
    public function getDatefavoris()
    {
        return $this->datefavoris;
    }

    /**
     * Set idannonceur
     *
     * @param \AppBundle\Entity\User $idannonceur
     *
     * @return Favoris
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
     * @return Favoris
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
     * @return Favoris
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

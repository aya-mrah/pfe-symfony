<?php

namespace AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Trajet
 *
 * @ORM\Table(name="trajet")
 * @ORM\Entity(repositoryClass="AnnonceBundle\Repository\TrajetRepository")
 */
class Trajet
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
     * @ORM\Column(name="date_publication", type="datetime")
     */
    private $datePublication;

    public function __construct(){
        $this->datePublication = new \DateTime('now');    
    }

   /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     * @ORM\Column(name="dateFin", type="date")   
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="ville_etape", type="string", length=255)
     */
    private $villeEtape;

    /**
     * @var string
     *
     * @ORM\Column(name="pays_depart", type="string", length=255)
     */
    private $paysDepart;

    /**
     * @var string
     *
     * @ORM\Column(name="pays_destination", type="string", length=255)
     */
    private $paysDestination;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="mode", type="string", length=255)
     */
    private $mode;

    /**
     * @var float
     *
     * @ORM\Column(name="poidsAtransporter", type="float")
     */
    private $poidsAtransporter;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_kg", type="float")
     */
    private $prixKg;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="string", length=255)
     */
    private $details;

    
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Trajet
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Trajet
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Trajet
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set villeEtape
     *
     * @param string $villeEtape
     *
     * @return Trajet
     */
    public function setVilleEtape($villeEtape)
    {
        $this->villeEtape = $villeEtape;

        return $this;
    }

    /**
     * Get villeEtape
     *
     * @return string
     */
    public function getVilleEtape()
    {
        return $this->villeEtape;
    }

    /**
     * Set paysDepart
     *
     * @param string $paysDepart
     *
     * @return Trajet
     */
    public function setPaysDepart($paysDepart)
    {
        $this->paysDepart = $paysDepart;

        return $this;
    }

    /**
     * Get paysDepart
     *
     * @return string
     */
    public function getPaysDepart()
    {
        return $this->paysDepart;
    }

    /**
     * Set paysDestination
     *
     * @param string $paysDestination
     *
     * @return Trajet
     */
    public function setPaysDestination($paysDestination)
    {
        $this->paysDestination = $paysDestination;

        return $this;
    }

    /**
     * Get paysDestination
     *
     * @return string
     */
    public function getPaysDestination()
    {
        return $this->paysDestination;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Trajet
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Trajet
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set mode
     *
     * @param string $mode
     *
     * @return Trajet
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set poidsAtransporter
     *
     * @param float $poidsAtransporter
     *
     * @return Trajet
     */
    public function setPoidsAtransporter($poidsAtransporter)
    {
        $this->poidsAtransporter = $poidsAtransporter;

        return $this;
    }

    /**
     * Get poidsAtransporter
     *
     * @return float
     */
    public function getPoidsAtransporter()
    {
        return $this->poidsAtransporter;
    }

    /**
     * Set prixKg
     *
     * @param float $prixKg
     *
     * @return Trajet
     */
    public function setPrixKg($prixKg)
    {
        $this->prixKg = $prixKg;

        return $this;
    }

    /**
     * Get prixKg
     *
     * @return float
     */
    public function getPrixKg()
    {
        return $this->prixKg;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Trajet
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Trajet
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }


    /**
     * Set idannonceur
     *
     * @param \AppBundle\Entity\User $idannonceur
     *
     * @return Trajet
     */
    public function setIdannonceur($idannonceur )
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
}

<?php

namespace AnnonceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Coli
 *
 * @ORM\Table(name="coli")
 * @ORM\Entity(repositoryClass="AnnonceBundle\Repository\ColiRepository")
 */
class Coli
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
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;

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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="nomreceiver", type="string", length=255)
     * @Assert\Length(
     *      min= 2, 
     *      max=100,   
     *       minMessage="Longeur du nom est superieur à {{ limit }}"
     * )
     */
   
    private $nomreceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="prenomreceiver", type="string", length=255)
     * @Assert\Length(
     *      min= 3, 
     *      max=100,   
     *       minMessage="Longeur du prénom est superieur à {{ limit }}"
     * )
     */
    private $prenomreceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="cinreceiver", type="string", length=255)
     * @Assert\Length(
     *      min= 8, 
     *      max=8,   
     *       exactMessage="Longeur de cin est egal{{ limit }}"
     * )
     */
    private $cinreceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="emailreceiver", type="string", length=255)
     * @Assert\Email( 
     *   message = "format invalid example@exemple.prefix", 
     *   checkMX = true 
     * ) 
     */
    
    private $emailreceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="telreceiver", type="string", length=255)
     */
 
    private $telreceiver;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\NotBlank
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="dimension_coli", type="string", length=255)
     */
    private $dimensionColi;

    /**
     * @var float
     *
     * @ORM\Column(name="poidsColis", type="float")
     */
    private $poidsColis;

    /**
     * @var float
     *
     * @ORM\Column(name="prixColis", type="float")
     * @Assert\GreaterThan(
     *     value = 0,
     *  message="le prix est superier à 0"
     * )
     */
   
    private $prixColis;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="codelivraison", type="string", length=255)
     */
    private $codelivraison;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true )
     */
    public $etat ;

    /**
     * @ORM\Column(type="string" ,nullable=true)
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(maxSize="500k")
     */
    public $path;
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
     * @return Coli
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
     * @return Coli
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
     * @return Coli
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
     * Set paysDepart
     *
     * @param string $paysDepart
     *
     * @return Coli
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
     * @return Coli
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
     * Set type
     *
     * @param string $type
     *
     * @return Coli
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
     * Set nomreceiver
     *
     * @param string $nomreceiver
     *
     * @return Coli
     */
    public function setNomreceiver($nomreceiver)
    {
        $this->nomreceiver = $nomreceiver;

        return $this;
    }

    /**
     * Get nomreceiver
     *
     * @return string
     */
    public function getNomreceiver()
    {
        return $this->nomreceiver;
    }

    /**
     * Set prenomreceiver
     *
     * @param string $prenomreceiver
     *
     * @return Coli
     */
    public function setPrenomreceiver($prenomreceiver)
    {
        $this->prenomreceiver = $prenomreceiver;

        return $this;
    }

    /**
     * Get prenomreceiver
     *
     * @return string
     */
    public function getPrenomreceiver()
    {
        return $this->prenomreceiver;
    }

    /**
     * Set cinreceiver
     *
     * @param string $cinreceiver
     *
     * @return Coli
     */
    public function setCinreceiver($cinreceiver)
    {
        $this->cinreceiver = $cinreceiver;

        return $this;
    }

    /**
     * Get cinreceiver
     *
     * @return string
     */
    public function getCinreceiver()
    {
        return $this->cinreceiver;
    }

    /**
     * Set emailreceiver
     *
     * @param string $emailreceiver
     *
     * @return Coli
     */
    public function setEmailreceiver($emailreceiver)
    {
        $this->emailreceiver = $emailreceiver;

        return $this;
    }

    /**
     * Get emailreceiver
     *
     * @return string
     */
    public function getEmailreceiver()
    {
        return $this->emailreceiver;
    }

    /**
     * Set telreceiver
     *
     * @param string $telreceiver
     *
     * @return Coli
     */
    public function setTelreceiver($telreceiver)
    {
        $this->telreceiver = $telreceiver;

        return $this;
    }

    /**
     * Get telreceiver
     *
     * @return string
     */
    public function getTelreceiver()
    {
        return $this->telreceiver;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Coli
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
     * Set dimensionColi
     *
     * @param string $dimensionColi
     *
     * @return Coli
     */
    public function setDimensionColi($dimensionColi)
    {
        $this->dimensionColi = $dimensionColi;

        return $this;
    }

    /**
     * Get dimensionColi
     *
     * @return string
     */
    public function getDimensionColi()
    {
        return $this->dimensionColi;
    }

    /**
     * Set poidsColis
     *
     * @param float $poidsColis
     *
     * @return Coli
     */
    public function setPoidsColis($poidsColis)
    {
        $this->poidsColis = $poidsColis;

        return $this;
    }

    /**
     * Get poidsColis
     *
     * @return float
     */
    public function getPoidsColis()
    {
        return $this->poidsColis;
    }

    /**
     * Set prixColis
     *
     * @param float $prixColis
     *
     * @return Coli
     */
    public function setPrixColis($prixColis)
    {
        $this->prixColis = $prixColis;

        return $this;
    }

    /**
     * Get prixColis
     *
     * @return float
     */
    public function getPrixColis()
    {
        return $this->prixColis;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Coli
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set codelivraison
     *
     * @param string $codelivraison
     *
     * @return Coli
     */
    public function setCodeLivraison($codelivraison)
    {
        $this->codelivraison = $codelivraison;

        return $this;
    }

    /**
     * Get codelivraison
     *
     * @return string
     */
    public function getCodeLivraison()
    {
        return $this->codelivraison;
    }

    
    public function getPath()
    {
        return $this->path;
    }

    
    public function setPath($path)
    {
        if( $path==null ){
            $this->path =$this->getPath();   
        }else{
        $this->path = $path;
    }
    return $this; 
    }

    /**
     * @return string
     */
    public function getetat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        if ($etat == null){
        $this->etat ="rouge";
       }else{
           $this->etat= $etat;
           
       }
    }

    /**
     * Set idannonceur
     *
     * @param \AppBundle\Entity\User $idannonceur
     *
     * @return Coli
     */
    public function setIdannonceur( $idannonceur)
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

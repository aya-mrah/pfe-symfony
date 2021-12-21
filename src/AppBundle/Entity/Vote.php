<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 */
class Vote
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
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;

    /**
     * @var float
     *
     * @ORM\Column(name="moyenne", type="float")
     */
    private $moyenne;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_vote", type="datetime")
     */
    private $dateVote;

    public function __construct(){
        
        $this->dateVote = new \DateTime('now');
    }

    /**
     * @var \Trajet
     *
     * @ORM\ManyToOne(targetEntity="AnnonceBundle\Entity\Trajet")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="idtrajet", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idtrajet;
    
    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="idv", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $idv; 

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Vote
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set moyenne
     *
     * @param float $moyenne
     *
     * @return Vote
     */
    public function setMoyenne($moyenne)
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    /**
     * Get moyenne
     *
     * @return float
     */
    public function getMoyenne()
    {
        return $this->moyenne;
    }

    /**
     * Set dateVote
     *
     * @param \DateTime $dateVote
     *
     * @return Vote
     */
    public function setDateVote($dateVote)
    {
        $this->dateVote = $dateVote;

        return $this;
    }

    /**
     * Get dateVote
     *
     * @return \DateTime
     */
    public function getDateVote()
    {
        return $this->dateVote;
    }

    /**
     * Set idtrajet
     *
     * @param \AnnonceBundle\Entity\Trajet $idtrajet
     *
     * @return Vote
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
     * Set idv
     *
     * @param \AppBundle\Entity\User $idv
     *
     * @return Vote
     */
    public function setIdv($idv)
    {
        $this->idv = $idv;

        return $this;
    }

    /**
     * Get idv
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdv()
    {
        return $this->idv;
    }

    /**
     * Set iduser
     *
     * @param \AppBundle\Entity\User $iduser
     *
     * @return Vote
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return \AppBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }
}

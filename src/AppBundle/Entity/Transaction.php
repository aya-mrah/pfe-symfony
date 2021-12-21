<?php
// src/Entity
namespace AppBundle\Entity;

use Beelab\PaypalBundle\Entity\Transaction as BaseTransaction;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class Transaction extends BaseTransaction
{   /**
     * @var \Coli
     *
     * @ORM\ManyToOne(targetEntity="AnnonceBundle\Entity\Coli")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcoli", referencedColumnName="id")
     * })
     */
    private $idcoli;
    
     /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idsrc", referencedColumnName="id")
     * })
     */
    private $idsrc;

     /**
     * @var int
     *
     * @ORM\Column(name="IsOk", type="smallint", nullable=true)
     */
    private $IsOk; 
    
    public function getDescription(): ?string
    {

        return null;
    }

    public function getItems(): array
    {
        return [];
    }

    public function getShippingAmount(): string
    {
        return '0.00';
    }

    /**
     * Set amount.
     *
     * @param string $amount
     *
     * @return Transaction
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Set response.
     *
     * @param array $response
     *
     * @return Transaction
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Set idcoli.
     *
     * @param \AnnonceBundle\Entity\Coli|null $idcoli
     *
     * @return Transaction
     */
    public function setIdcoli($idcoli )
    {
        $this->idcoli = $idcoli;

        return $this;
    }

    /**
     * Get idcoli.
     *
     * @return \AnnonceBundle\Entity\Coli|null
     */
    public function getIdcoli()
    {
        return $this->idcoli;
    }

    /**
     * Set idsrc.
     *
     * @param \AppBundle\Entity\User|null $idsrc
     *
     * @return Transaction
     */
    public function setIdsrc($idsrc)
    {
        $this->idsrc = $idsrc;

        return $this;
    }

    /**
     * Get idsrc.
     *
     * @return \AppBundle\Entity\User|null
     */
    public function getIdsrc()
    {
        return $this->idsrc;
    }

    /**
     * Set isOk.
     *
     * @param int $isOk
     *
     * @return Transaction
     */
    public function setIsOk($isOk)
    {
        $this->IsOk = $isOk;

        return $this;
    }

    /**
     * Get isOk.
     *
     * @return int
     */
    public function getIsOk()
    {
        return $this->IsOk;
    }
}

<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\RealCurrency;

/**
 * @ORM\Entity
 * @ORM\Table(name="cryptoCurrency")
 */
class CryptoCurrency extends CurrencyBase {

	/**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="RealCurrency", inversedBy="realCurrencies")
     * @ORM\JoinTable(name="crypto_real")
     */
    private $realCurrencies;

    /**
     * @ORM\Column(type="string")
     */
    public $code;

    /**
     * @ORM\Column(type="decimal", scale=5)
     */
    public $bid;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    public $ask;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    public $high;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    public $low;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    public $last;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    public $volume;

    /**
     * @ORM\Column(type="string", length=10)
     */
    public $cpair;

    public function __construct() {
        $this->realCurrencies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getRealCurrencies()
    {

        return $this->realCurrencies;
    }

    public function getBid()
    {
        return $this->bid;
    }

    public function getAsk()
    {
        return $this->ask;
    }

    public function getHigh()
    {
        return $this->high;
    }

    public function getLow()
    {
        return $this->low;
    }

    public function getLast()
    {
        return $this->last;
    }

    public function getVolume()
    {
        return $this->volume;
    }

    public function getCpair()
    {
        return $this->cpair;
    }


}
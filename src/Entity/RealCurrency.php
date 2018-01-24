<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CryptoCurrency;

/**
 * @ORM\Entity
 * @ORM\Table(name="realCurrency")
 */
class RealCurrency extends CurrencyBase {

    /**
     * Many Groups have Many Users.
     * @ORM\ManyToMany(targetEntity="CryptoCurrency", mappedBy="realCurrencies")
     */
    private $cryptoCurrencies;

    /**
     * @ORM\Column(type="text")
     */
    public $code;

    public function __construct() {
        $this->cryptoCurrencies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString() {
        return $this->code;
    }

    public function getCryptoCurrencies()
    {
        return $this->cryptoCurrencies;
    }
}
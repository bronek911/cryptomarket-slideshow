<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

abstract class CurrencyBase {
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $name;

    /**
     * @ORM\Column(type="text")
     */
    public $code;

    /**
     * @ORM\Column(type="text")
     */
    public $description;
}
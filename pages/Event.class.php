<?php
class Event
{
    private $nomEvenement;
    private $dateEvenement;


    public function __construct($nomEvenement, $dateEvenement)
    {
        $this->nomEvenement = $nomEvenement;
        $this->dateEvenement = $dateEvenement;
    }

    public function __toString()
    {
        return "Nom : " . $this->nomEvenement . ", Date : " . $this->dateEvenement;
    }

    public function getNomEvenement()
    {
        return $this->nomEvenement;
    }

    public function getdateEvenement()
    {
        return $this->dateEvenement;
    }
    public function setNomEvenement($nomEvenement)
    {
        $this->nomEvenement = $nomEvenement;
    }

    public function setDateEvenement($dateEvenement)
    {
        $this->dateEvenement = $dateEvenement;
    }
}
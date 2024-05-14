<?php
class Event
{
    private $idEvenement;
    private $nomEvenement;
    private $dateEvenement;

    public function __construct($idEvenement, $nomEvenement, $dateEvenement)
    {
        $this->idEvenement = $idEvenement;
        $this->nomEvenement = $nomEvenement;
        $this->dateEvenement = $dateEvenement;
    }

    public function __toString()
    {
        return "Nom : " . $this->nomEvenement . ", Date : " . $this->dateEvenement;
    }

    public function getIdEvenement()
    {
        return $this->idEvenement;
    }

    public function getNomEvenement()
    {
        return $this->nomEvenement;
    }

    public function getDateEvenement()
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

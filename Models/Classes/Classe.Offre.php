<?php


class Offre
{
    public $Identifiant;
    public $Intitule;
    public $Date_Debut_Publication;
    public $Duree_Diffusion;
    public $Date_Debut_Contrat;
    public $Nombre_Poste;
    public $Localisation;
    public $Description_Poste;
    public $Description_Profil;

    public function __construct()
    {
      $this->Identifiant = 0;

    }
}

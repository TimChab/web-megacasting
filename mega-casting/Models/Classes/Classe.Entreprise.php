<?php


class Offre
{
    public $Identifiant;
    public $Telephone;
    public $Email;
    public $Siret;
    public $Libelle;
    public $Url;//Dans le cas d'un partenaire de diffusion. Si c'est un client il n'y en a pas 

    public function __construct()
    {
      $this->Identifiant = 0

    }
}

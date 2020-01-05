<?php
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Models/Repositories/Repositories.Offre.php';
try
{
  $OffreList = OffreRepository::GetAllOffres();

  $toReturn = array();
  foreach ($OffreList as $donnee)
  {
    $item = array();

    $item['Identifiant_Offre'] = $donnee->Identifiant;
    $item['Intitule_Offre'] =  $donnee->Intitule;
    $item['Description_Poste_Offre'] =  $donnee->Description_Poste;
    $item['Description_Profil_Offre'] =  $donnee->Description_Profil;
    $item['Nombre_Poste_Offre'] =  $donnee->Nombre_Poste;

    array_push($toReturn, $item);
  }
}

catch(EXCEPTION $e)
{
    die('Erreur : '.$e->getMessage());
}

header('Content-Type: json');
echo json_encode($toReturn);
?>

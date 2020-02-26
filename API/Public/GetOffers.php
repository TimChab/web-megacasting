<?php
require_once __DIR__.'/../../Config/base.php';
require_once __DIR__.'/../../Models/Repositories/Repositories.Offre.php';

// Booléan pour savoir si la pagination est activée
$pagination = 0;

// Choix du format
if (isset($_GET['format'])) {
  $format = $_GET['format'];
}

// Choix du métier
if (isset($_GET['metier'])) {
  $metier = $_GET['metier'];
} else {
  $metier = null;
}

// Si une page est spécifiée
if (isset($_GET['page'])) {
  $page = $_GET['page'];
  $pagination = 1;
  echo 'page';
  // On regarde le nombre d'éléments par page
  if (isset($_GET['nb_elem'])) {
    $nb_elem = $_GET['nb_elem'];
    $pagination = 1;
    echo 'elem';
  } else {
    $nb_elem = -1;
  }
} else {
  // Pas de pagination
  $page = -1;
  echo 'no apge';
  if (isset($_GET['nb_elem'])) {
    echo 'elem';
    $nb_elem = $_GET['nb_elem'];
  } else {
    // Pas de nombre
    $nb_elem = -1;
    echo 'no elem';
  }
}

// Pas de page et pas de nombre d'éléments
if ($pagination == 0 && $nb_elem == -1) {
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
}

// Pas de pagination mais un nombre spécifiée
if ($pagination == 0 && $nb_elem > -1) {
  try
  {
  // On dit que c'est donc la première page qui sera renvoyée
  $OffreList = OffreRepository::GetOffreByPage($nb_elem, 1);

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
  } }catch(EXCEPTION $e)
  {
    die('Erreur : '.$e->getMessage());
  }

}

// Pas de nombre mais une page spécifiée
if ($pagination == 1 && $nb_elem == -1) {
  // On dit que c'est donc la première page qui sera renvoyée
  /*$OffreList = OffreRepository::GetOffreByPage(1, $page);*/

  $toReturn = array();
  /*
  foreach ($OffreList as $donnee)
  {
    $item = array();

    $item['Identifiant_Offre'] = $donnee->Identifiant;
    $item['Intitule_Offre'] =  $donnee->Intitule;
    $item['Description_Poste_Offre'] =  $donnee->Description_Poste;
    $item['Description_Profil_Offre'] =  $donnee->Description_Profil;
    $item['Nombre_Poste_Offre'] =  $donnee->Nombre_Poste;

    array_push($toReturn, $item);
  } catch(EXCEPTION $e)
  {
    die('Erreur : '.$e->getMessage());
  }*/
}

// Pagination + Nombre
if ($pagination == 1 && $nb_elem > -1) {
  try
  {
  $OffreList = OffreRepository::GetOffreByPage($nb_elem, $page);
  var_dump($OffreList);
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
  } }catch(EXCEPTION $e)
  {
    die('Erreur : '.$e->getMessage());
  }
}

$final = array();
$count = OffreRepository::GetNbOffre();
array_push($final, $count[0]);
array_push($final, $toReturn);

// Json
if ($format == 'json') {
  header('Content-Type: json');
  header('HTTP/1.0: 200');
  echo json_encode($final);
} else {
  // XML
  header('Content-Type: text/xml');
  header('HTTP/1.0: 200');
  echo xmlrpc_encode($final);
}


?>

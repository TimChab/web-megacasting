<?php

require_once __DIR__.'/../Config/base.php';
try
{

  $conn = Base::CreateConnexion();
  if(isset($_GET['type'])) {
    if ($_GET['type'] == 'logo') {
      $reponse = $conn->prepare('SELECT Logo FROM Sites WHERE Identifiant =:id');
    } elseif ($_GET['type'] == 'image') {
      $reponse = $conn->prepare('SELECT Data FROM Photos WHERE Identifiant =:id');
    }
  }

  $reponse->bindValue('id',$_GET['id'],PDO::PARAM_INT);
  $reponse->execute();
  $donnees = $reponse->fetch();

  $reponse->closeCursor();
}

catch(EXCEPTION $e)
{
    die('Erreur : '.$e->getMessage());
}

header('Content-Type: image');
if ($_GET['type'] == 'logo') {
  echo $donnees['Logo'];
} elseif ($_GET['type'] == 'image') {
  echo $donnees['Data'];
}


?>

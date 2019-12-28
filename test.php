<?php

require_once __DIR__.'/../Models/Repositories/Repositories.Image.php;';
//require_once __DIR__.'/../Models/Repositories/Repositories.Entreprise.php;';

echo __DIR__.'/../Models/Repositories/Repositories.Entreprise.php;';
$EntrepriseList = EntrepriseRepository::GetAllEntreprises();
 var_dump($EntrepriseList);
?>

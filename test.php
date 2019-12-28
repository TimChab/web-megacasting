<?php
require_once __DIR__.'/Models/Repositories/Repositories.Entreprise.php';
$EntrepriseList = EntrepriseRepository::GetAllEntreprises();
var_dump($EntrepriseList);
?>

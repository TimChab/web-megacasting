

<?php
require_once __DIR__.'/../Models/Repositories/Repositories.Entreprise.php';
$EntrepriseList = EntrepriseRepository::GetAllEntreprises();

 foreach ($EntrepriseList as $key => $entreprise) {
   echo '
   <div class="card">
   <img src="/assets/images/avatar.png" alt="Avatar" style="width:10%">
   <div class="container">
   <h4><b>'.$entreprise->Libelle.'</b></h4>
   <p>'.$entreprise->Email.'</p>
   </div>
   </div>
   ';
 }
?>


<style media="screen">
.card {
/* Add shadows to create the "card" effect */
box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
transition: 0.3s;
}

/* On mouse-over, add a deeper shadow */
.card:hover {
box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

/* Add some padding inside the card container */
.container {
padding: 2px 16px;
}

div{
  vertical-align: center;
}

</style>
